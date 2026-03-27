<?php 
// pull necessary files header and to connect to database
require_once '../foundation/header.php';
require_once '../config/connectdb.php';

$cv = null;

// fetch cv and display to homepage also grabbing id from url
if (isset($_GET['id'])) {
    try {
        // preventing sql injection
        $stmt = $db->prepare("SELECT * FROM cvs WHERE id = ?");
        $stmt->execute(array($_GET['id']));
        $cv = $stmt->fetch();
        // catches if any errors happen
    } catch (PDOException $ex) {
        echo "<div class='errorBanner'>Database error: " . $ex->getMessage() . "</div>";
    }
}
?>

<style>
        body {
            background-image: linear-gradient(to top, #cfd9df 0%, #e2ebf0 100%);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
        }

        h1 {
            color: #2d3748;
            margin-top: 0;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background-image: linear-gradient(to top, #cfd9df 0%, #e2ebf0 100%);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .cvinfo {
            margin-top: 20px;
            line-height: 1.8;
            color: #4a5568;
        }
</style>

<div class="container">
    <?php if ($cv): ?>
        <h1>
            <?php echo htmlspecialchars($cv['name']); ?>'s CV
        </h1>
        
        <div class="cvinfo">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($cv['email']); ?></p>
            <p><strong>Key Programming Languages:</strong> <br>
                <?php echo nl2br(htmlspecialchars($cv['keyprogramming'] ?? 'Not specified')); ?>
            </p>
            <p><strong>Profile:</strong> <br>
                <?php echo nl2br(htmlspecialchars($cv['profile'] ?? 'Not specified')); ?>
            </p>
            <p><strong>Education:</strong> <br>
                <?php echo nl2br(htmlspecialchars($cv['education'] ?? 'Not specified')); ?>
            </p>
            <p><strong>Portfolio / URL Links:</strong> <br>
                <?php 
                $links = $cv['URLlinks'] ?? '';
                if ($links) {
                    echo "<a href='" . htmlspecialchars($links) . "' target='_blank' style='color: #3182ce;'>" . htmlspecialchars($links) . "</a>";
                } else {
                    echo "Not specified";
                }
                ?>
            </p>
        </div>
        <div style="margin-top: 30px;">
            <a href="index.php" style="color: #3182ce; text-decoration: none;">&larr; Back to all CVs</a>
        </div>
    <?php else: ?>
        <h2 style="text-align:center; color: #e53e3e;">CV Not Found</h2>
        <p style="text-align:center;">The requested CV does not exist. <a href="index.php">Go back</a>.</p>
    <?php endif; ?>
</div>

<?php require_once '../foundation/footer.php'; ?>