<?php
// Koneksi ke database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "topupstore";

$koneksi = new mysqli($hostname, $username, $password, $database);

if($koneksi->connect_error) {
    die("Koneksi Gagal: " . $koneksi->connect_error);
}

// Autentikasi admin (sederhana)
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

// Fungsi untuk mendapatkan semua pesanan
function getOrders($conn, $search = null, $status_filter = null) {
    $sql = "SELECT * FROM orders WHERE 1=1";
    $params = [];
    $types = "";
    
    if($search) {
        $sql .= " AND (game LIKE ? OR product LIKE ? OR player_id LIKE ? OR player_name LIKE ?)";
        $search_term = "%$search%";
        $params = array_fill(0, 4, $search_term);
        $types = "ssss";
    }
    
    if($status_filter) {
        $sql .= " AND status = ?";
        $params[] = $status_filter;
        $types .= "s";
    }
    
    $sql .= " ORDER BY order_date DESC";
    
    $stmt = $conn->prepare($sql);
    
    if(!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orders = [];
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    
    return $orders;
}

// Proses update status
if(isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = in_array($_POST['new_status'], ['pending', 'completed', 'failed']) ? $_POST['new_status'] : 'pending';
    
    $stmt = $koneksi->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: admin.php");
    exit;
}

// Proses hapus pesanan
if(isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    $stmt = $koneksi->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: admin.php");
    exit;
}

// Ambil parameter pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : null;

$orders = getOrders($koneksi, $search, $status_filter);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Analog Store</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Admin Panel - Orders Management</h1>
        
        <div class="admin-nav">
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin.php" class="active">Orders</a>
            <a href="admin_products.php">Products</a>
            <a href="admin_users.php">Users</a>
            <a href="admin_settings.php">Settings</a>
            <a href="logout.php" style="float: right;">Logout</a>
        </div>
        
        <div class="search-bar">
            <form method="GET">
                <input type="text" name="search" placeholder="Search orders..." 
                       value="<?php echo htmlspecialchars($search ?? ''); ?>">
                <select name="status_filter">
                    <option value="">All Status</option>
                    <option value="pending" <?php echo ($status_filter == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="completed" <?php echo ($status_filter == 'completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="failed" <?php echo ($status_filter == 'failed') ? 'selected' : ''; ?>>Failed</option>
                </select>
                <button type="submit">Filter</button>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Game</th>
                    <th>Product</th>
                    <th>Player ID</th>
                    <th>Player Name</th>
                    <th>Price</th>
                    <th>Payment Method</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($orders)): ?>
                    <tr>
                        <td colspan="10" class="no-orders">No orders found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars($order['game']); ?></td>
                        <td><?php echo htmlspecialchars($order['product']); ?></td>
                        <td><?php echo htmlspecialchars($order['player_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['player_name']); ?></td>
                        <td>Rp <?php echo number_format($order['price'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                        <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                        <td>
                            <form method="POST" class="status-form">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <select name="new_status" onchange="this.form.submit()" class="status-select status-<?php echo $order['status']; ?>">
                                    <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="completed" <?php echo ($order['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                    <option value="failed" <?php echo ($order['status'] == 'failed') ? 'selected' : ''; ?>>Failed</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                        <td class="actions">
                            <a href="admin_order_detail.php?id=<?php echo $order['id']; ?>" class="action-btn edit-btn">View</a>
                            <a href="admin.php?delete_id=<?php echo $order['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>