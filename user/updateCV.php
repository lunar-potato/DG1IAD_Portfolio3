<?php 
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../foundation/header.php';
require_once '../config/connectdb.php';

$userID = $_SESSION['userid'];
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyprogramming = trim($_POST['keyprogramming'] ?? '');
    $profile = trim($_POST['profile'] ?? '');
    $education = trim($_POST['education'] ?? '');
    $URLlinks = trim($_POST['URLlinks'] ?? '');

    try {
        $updateStmt = $db->prepare("UPDATE cvs SET keyprogramming = ?, profile = ?, education = ?, URLlinks = ? WHERE id = ?");
        $updateStmt->execute(array($keyprogramming, $profile, $education, $URLlinks, $userID));
        $successMessage = "Your CV has been successfully updated";
    } catch (PDOException $ex) {
        $errorMessage = "Failed to update CV: " . $ex->getMessage();
    }
}

try {
    $fetchStmt = $db->prepare("SELECT * FROM cvs WHERE id = ?");
    $fetchStmt->execute(array($userID));
    $currentUser = $fetchStmt->fetch();
} catch (PDOException $ex) {
    $errorMessage = "Failed to fetch data: " . $ex->getMessage();
}
?>

<div style="max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgb(0, 0, 0, 0.05);">
    <h1 style="color: #2d3748;margin-top: 0;">Update My CV</h1>
    <p style="color: #718096; margin-bottom: 30px;">Welcome, <?php echo htmlspecialchars($currentUser['name'] ?? 'User'); ?>!
    Fill out the details to complete your profile.
    </p>

    <?php if ($successMessage): ?>
        <div style="background-color: #c6f6d5; color: #2f855a; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($errorMessage): ?>
        <div style="background-color: #fed7d7; color: #c53030; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="updateCV.php">
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #4a5568;">Key Programming Languages:</label>
            <input type="text" name="keyprogramming" value="<?php echo htmlspecialchars($currentUser['keyprogramming'] ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #4a5568;">Profile</label>
            <textarea name="profile" rows="5" style="width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; resize: vertical;"><?php echo htmlspecialchars($currentUser['profile'] ?? ''); ?></textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #4a5568;">Education</label>
            <textarea name="profile" rows="5" style="width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; resize: vertical;"><?php echo htmlspecialchars($currentUser['education'] ?? ''); ?></textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #4a5568;">Github Link</label>
            <input type="url" name="URLlinks" value="<?php echo htmlspecialchars($currentUser['URLlinks'] ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box;" placeholder="https://github.com/yourusername">
        </div>

        <button type="submit" class="btnPrimary" style="width: 100%; padding: 12px; border: none; font-size: 16px; cursor: pointer;">Save Changes</button>
    </form>
</div>

<?php require_once '../foundation/footer.php'; ?>
