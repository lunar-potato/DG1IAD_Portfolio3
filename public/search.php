<?php 
require_once '../foundation/header.php';
require_once '../config/connectdb.php';

$results = [];
$searchQuery = trim($_GET['q'] ?? '');

if ($searchQuery) {
    try {
        $stmt = $db->prepare("SELECT id, name, email, keyprogramming FROM cvs WHERE name LIKE ? OR email LIKE ? OR keyprogramming LIKE ? ORDER BY id DESC");
        $likeQuery = '%' . $searchQuery . '%';
        $stmt->execute([$likeQuery, $likeQuery, $likeQuery]);
        $results = $stmt->fetchAll();
    } catch (PDOException $ex) {
        echo "<div style='color:red; text-align:center;'>Database error: " . $ex->getMessage() . "</div>";
    }
}
?>

<style> 
    body {
        background-image: linear-gradient(to top, #cfd9df 0%, #e2ebf0 100%);
    }

    h1 {
        text-align:center;
        color: #2d3748;
    }

    h2 {
        margin-top: 0;
        color: #2d3748;
    }

    h3 {
        color" #4a5568;
        margin-bottom: 20px;
    }

    .formContainer {
        max-width: 600px;
        margin: 0 auto 40px auto;
        text-align: center;
    }

    form {
        display: flex;
        gap: 10px;
    }

    input {
        flex: 1;
        padding: 12px;
        border: 1px solid #cbd5e0;
        border-radius: 6px;
        font-size: 16px;
    }

    .btnPrimary {
        border: none;
        cursor: pointer;
    }

</style>

    <h1>Search CVs</h1>

    <div class="formContainer">
        <form method="GET" action="search.php">
            <input type="text" name="q" palceholder="Search by name or language" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit" class="btnPrimary">Search</button>
        </form>
    </div>

    <?php if ($searchQuery) : ?>
        <h3>Found <? echo count ($results); ?> result(s) for "<?php echo htmlspecialchars($searchQuery); ?>"</h3>

        <div class="cvGrid">
            <?php if (count($results) > 0): ?>
                <?php foreach ($results as $cv): ?>
                    <div class="cvCard">
                        <h2>
                            <?php echo htmlspecialchars($cv['name']); ?>
                        </h2>
                        <p>
                            <strong>Skills</strong>
                            <?php echo htmlspecialchars($cv['keyprognameramming'] ?? ''); ?>
                        </p>
                        <a href="cvDetails.php?id=<?php echo $cv['id']; ?>" class="btnPrimary">View CV</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-columnL 1 / -1;">No programmers found</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php require_once '../foundation/footer.php'; ?>