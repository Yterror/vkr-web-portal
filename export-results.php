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


$rows = [];

$rows[] = ['Результаты опроса'];
$rows[] = ['Название', $poll['POLL_TITLE']];
$rows[] = ['Всего участников', $total_users];
$rows[] = [''];
$rows[] = ['Вопрос', 'Вариант ответа', 'Количество', 'Процент'];


foreach ($questions as $question) {

    $sql = "SELECT *
            FROM answer_options
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

        $rows[] = [
            $question['QST_ORDER'] . '. ' . $question['QST_TEXT'],
            $option['OPT_TEXT'],
            $count,
            $percent . '%'
        ];
    }
}


function escapeXml($text)
{
    return htmlspecialchars($text, ENT_XML1, 'UTF-8');
}


$sheetRows = '';

foreach ($rows as $row) {

    $sheetRows .= '<row>';

    foreach ($row as $cell) {

        $cell = escapeXml($cell);

        $sheetRows .= '<c t="inlineStr"><is><t>'
            . $cell .
            '</t></is></c>';
    }

    $sheetRows .= '</row>';
}


$sheetXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
    . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
    . '<sheetData>'
    . $sheetRows
    . '</sheetData>'
    . '</worksheet>';


$contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
    . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
    . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
    . '<Default Extension="xml" ContentType="application/xml"/>'
    . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
    . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
    . '</Types>';


$rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
    . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
    . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
    . '</Relationships>';


$workbook = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
    . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
    . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
    . '<sheets>'
    . '<sheet name="Результаты" sheetId="1" r:id="rId1"/>'
    . '</sheets>'
    . '</workbook>';


$workbookRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
    . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
    . '<Relationship Id="rId1" '
    . 'Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" '
    . 'Target="worksheets/sheet1.xml"/>'
    . '</Relationships>';


$file = tempnam(sys_get_temp_dir(), 'excel_');
$zip = new ZipArchive();

$zip->open($file, ZipArchive::CREATE);

$zip->addFromString('[Content_Types].xml', $contentTypes);
$zip->addFromString('_rels/.rels', $rels);
$zip->addFromString('xl/workbook.xml', $workbook);
$zip->addFromString('xl/_rels/workbook.xml.rels', $workbookRels);
$zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);

$zip->close();


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="results.xlsx"');
header('Content-Length: ' . filesize($file));

readfile($file);

unlink($file);

exit;