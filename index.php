<?php
function isValidIranianNationalCode(string $code): bool
{
    if (!preg_match('/^\d{10}$/', $code)) {
        return false;
    }

    if (preg_match('/^(\d)\1{9}$/', $code)) {
        return false;
    }

    $check = (int) $code[9];
    $sum = 0;

    for ($i = 0; $i < 9; $i++) {
        $sum += (int) $code[$i] * (10 - $i);
    }

    $remainder = $sum % 11;

    return ($remainder < 2 && $check == $remainder) || ($remainder >= 2 && $check == (11 - $remainder));
}

$message = '';
$alertClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nationalCode = trim($_POST['nationalCode'] ?? '');
    $safeCode = htmlspecialchars($nationalCode);

    if (isValidIranianNationalCode($nationalCode)) {
        $message = "✅ کد ملی $safeCode صحیح است.";
        $alertClass = 'success';
    } else {
        $message = "❌ کد ملی $safeCode معتبر نیست!";
        $alertClass = 'danger';
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>بررسی صحت کد ملی</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            direction: rtl;
            text-align: center;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>بررسی صحت کد ملی</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nationalCode" class="form-label">کد ملی خود را وارد کنید:</label>
            <input type="text" class="form-control" id="nationalCode" name="nationalCode" required>
        </div>
        <button type="submit" class="btn btn-primary">بررسی</button>
    </form>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $alertClass ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
