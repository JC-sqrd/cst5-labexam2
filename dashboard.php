<?php
include 'db_connection.php';
include 'verify.php';   
include 'logout.php';   
include 'script.php';
include 'functions.php';

$sql = "SELECT usr_id, usr_name, usr_fname, usr_mname, usr_phone, usr_dob ,usr_image
        FROM users  
        WHERE usr_status = 1";

        $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            include 'head.php';

        ?>

    </head>

            <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php 
                        echo htmlspecialchars($_SESSION['msg']); 
                        unset($_SESSION['msg']); 
                    ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>


<body class="container py-4">

    <h2 class="mb-4">Welcome,
        <span class="text-primary">
            <?php displayName(); ?>
        </span>!
    </h2>

    <h3 class="mb-3">Users List</h3>
    <div class="table-responsive">
        <table id="table2" class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Contact</th>
                    <th>Date of Birth</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= ($row['usr_id']); ?></td>
                    <td class="text-center">
                        <img src="uploads/<?= htmlspecialchars($row['usr_image'] ?? 'avatar.png') ?>"style="width:60px;height:60px;object-fit:cover;border-radius:50%;">
                    </td>
                    <td><?= ($row['usr_name']); ?></td>
                    <td><?= ($row['usr_fname'].' '.$row['usr_mname']); ?></td>
                    <td><?= ($row['usr_phone']); ?></td>
                    <td><?= ($row['usr_dob']); ?></td>
                    <td>
                        <!-- Update Button -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#updateModal<?= $row['usr_id']; ?>">Update</button>

                        <!-- Delete Button -->
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal<?= $row['usr_id']; ?>">Delete</button>
                    </td>
                </tr>

               <!-- Update Modal for this user -->
                <div class="modal fade" id="updateModal<?= $row['usr_id']; ?>" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="update_user.php" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Update User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                        <input type="hidden" name="usr_id" value="<?= $row['usr_id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="usr_name"
                                value="<?= ($row['usr_name']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="usr_fname"
                                value="<?= ($row['usr_fname']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="usr_mname"
                                value="<?= ($row['usr_mname']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="usr_phone"
                                value="<?= ($row['usr_phone']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="usr_dob"
                                value="<?= ($row['usr_dob']); ?>">
                        </div>

                        <!-- ✅ Image Upload -->
                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" class="form-control" name="usr_image" accept="image/*">
                            <small class="text-muted">Allowed: JPG, PNG, GIF, WEBP</small>

                            <!-- Optional: show current image if you have it in DB -->
                            <?php if (!empty($row['usr_image'])): ?>
                            <div class="mt-2">
                                <img src="uploads/<?= htmlspecialchars($row['usr_image']); ?>"
                                    alt="Current image" style="max-height:120px;" class="img-thumbnail">
                            </div>
                            <?php endif; ?>
                        </div>
                        </div>

                        <div class="modal-footer">
                        <button type="submit" name="update_user" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    </form>
                </div>
                </div> 

                <!-- Delete Modal for this user -->
                <div class="modal fade" id="deleteModal<?= $row['usr_id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" action="delete_user.php">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="usr_id" value="<?= $row['usr_id']; ?>">
                                    <p class="text-danger">Are you sure you want to delete user
                                        <strong><?= ($row['usr_name']); ?></strong>?
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="delete_user" class="btn btn-danger">Yes, Delete</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                

                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No users found.</td>
                </tr>
                <?php endif; ?>
                </tbody>
        </table>
    </div>

    <form method="POST" action="">
        <button type="submit" name="logout" class="btn btn-danger mt-3">Logout</button>
    </form>

</body>

</html>