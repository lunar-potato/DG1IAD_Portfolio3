<?php
// pull ui and connection to database
require_once '../foundation/header.php';
require_once '../config/connectdb.php';

try {
    // fetching all cvs to display on homepage
    $stmt = $db->query("SELECT id, name, email, keyprogramming FROM cvs ORDER BY id DESC");
    $cvs = $stmt->fetchAll();
} catch (PDOException $ex) {
    echo "<div style='color:red; text-align:center;'>Database error: " . $ex->getMessage() . "</div>";
    $cvs = [];
}
?>

<div style="background-image: linear-gradient(to top, #cfd9df 0%, #e2ebf0 100%);">
<h1 style="text-align:center; margin-bottom: 40px; color: #2d3748;">Browse CVs</h1>
 
<!-- grid ui to make it readable and modern -->
<div class="cvGrid">
    <!-- if statement to check if there are any existing cvs  -->
    <?php if (count($cvs) > 0) : ?>
        <?php foreach ($cvs as $cv) : ?>
            <div class="cvCard" style="margin: 6px;">
                <h2 style="margin-top: 0; color: #2d3748;">
                    <?php echo htmlspecialchars($cv['name'] ?? 'Unknown Programmer'); ?>
                </h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($cv['email'] ?? 'N/A'); ?></p>
                <p><strong>Key Skills:</strong> 
                    <?php echo htmlspecialchars($cv['keyprogramming'] ?? 'Not specified yet'); ?>
                </p>
                
                <div style="margin-top: 20px;">
                    <a href="cvDetails.php?id=<?php echo $cv['id']; ?>" class="btnPrimary">View Full CV</a>
                </div>
            </div>
        <?php endforeach; ?> 
    <?php else : ?>
        <!-- if no cvs found, redirect to register to sign up and make a cv  -->
        <p style="text-align:center; grid-column: 1 / -1;">
            No CVs found in the database yet. Be the first to <a href="../auth/register.php" style="color:#3182ce;">register</a>!
        </p>
    <?php endif; ?>
</div>
    </div>
    <?php 
    require_once '../foundation/footer.php'; 
    ?>