<?php

session_start();

require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 1 && $_SESSION['user_role'] != 2)) {
    header('Location: login.php');
    exit;
}

$poll_id = $_GET['id'];

$sql = "SELECT * FROM polls WHERE POLL_ID = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$poll_id]);

$poll = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$poll) {
    die('Опрос не найден.');
}

$sql = "SELECT COUNT(DISTINCT PART_USER_ID)
        FROM poll_participants
        WHERE PART_POLL_ID = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$poll_id]);

$total_users = $stmt->fetchColumn();

$sql = "SELECT * FROM questions
        WHERE QST_POLL_ID = ?
        ORDER BY QST_ORDER";

$stmt = $pdo->prepare($sql);
$stmt->execute([$poll_id]);

$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);


function escapeXml($text)
{
    return htmlspecialchars($text, ENT_XML1, 'UTF-8');
}


$documentBody = '';

$documentBody .= '<w:p>
    <w:r>
        <w:rPr>
            <w:b/>
        </w:rPr>
        <w:t>Результаты опроса</w:t>
    </w:r>
</w:p>';

$documentBody .= '<w:p>
    <w:r>
        <w:t>Название: ' . escapeXml($poll['POLL_TITLE']) . '</w:t>
    </w:r>
</w:p>';

$documentBody .= '<w:p>
    <w:r>
        <w:t>Всего участников: ' . $total_users . '</w:t>
    </w:r>
</w:p>';


foreach ($questions as $question) {

    $documentBody .= '<w:p>
        <w:r>
            <w:rPr>
                <w:b/>
            </w:rPr>
            <w:t>' .
            escapeXml($question['QST_ORDER'] . '. ' . $question['QST_TEXT']) .
            '</w:t>
        </w:r>
    </w:p>';


    $sql = "SELECT * FROM answer_options
            WHERE OPT_QST_ID = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$question['QST_ID']]);

    $options = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($options as $option) {

        $sql = "SELECT COUNT(DISTINCT ANS_USER_ID)
                FROM user_answers
                WHERE ANS_OPT_ID = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$option['OPT_ID']]);

        $count = $stmt->fetchColumn();

        if ($total_users > 0) {
            $percent = round(($count / $total_users) * 100);
        } else {
            $percent = 0;
        }

        $documentBody .= '<w:p>
            <w:r>
                <w:t>' .
                escapeXml($option['OPT_TEXT']) .
                ' — ' . $count . ' ответов — ' . $percent . '%' .
                '</w:t>
            </w:r>
        </w:p>';
    }
}


$documentXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>

<w:document
xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">

<w:body>

' . $documentBody . '

<w:sectPr>

    <w:pgSz w:w="11906" w:h="16838"/>

    <w:pgMar
        w:top="1440"
        w:right="1440"
        w:bottom="1440"
        w:left="1440"/>

</w:sectPr>

</w:body>

</w:document>';


$contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>

<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">

<Default
Extension="rels"
ContentType="application/vnd.openxmlformats-package.relationships+xml"/>

<Default
Extension="xml"
ContentType="application/xml"/>

<Override
PartName="/word/document.xml"
ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>

</Types>';


$rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>

<Relationships
xmlns="http://schemas.openxmlformats.org/package/2006/relationships">

<Relationship
Id="rId1"
Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument"
Target="word/document.xml"/>

</Relationships>';


$documentRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>

<Relationships
xmlns="http://schemas.openxmlformats.org/package/2006/relationships">

</Relationships>';


$file = tempnam(sys_get_temp_dir(), 'word_');

$zip = new ZipArchive();

$zip->open($file, ZipArchive::CREATE);

$zip->addFromString('[Content_Types].xml', $contentTypes);

$zip->addFromString('_rels/.rels', $rels);

$zip->addFromString('word/document.xml', $documentXml);

$zip->addFromString('word/_rels/document.xml.rels', $documentRels);

$zip->close();


header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

header('Content-Disposition: attachment; filename="results.docx"');

header('Content-Length: ' . filesize($file));

readfile($file);

unlink($file);

exit;