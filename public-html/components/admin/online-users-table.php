<div class="container-fluid">
    <table class="table">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Permission Level</th>
        <th scope="col">User ID</th>
    </tr>
    </thead>
    <tbody>
    <?php 
        $users = $dao->getOnlineUsers();
        $count = 1;
        foreach($users as $user) { ?>
        <tr>
        <td><?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']); ?></td>
        <td><?php echo htmlspecialchars($user['email']); ?></td>
        <td><?php echo $user['permission_id']; ?></td>
        <td><?php echo $user['user_id']; ?></td>
        </tr>
    <?php }?>
    </tbody>
    </table>
</div>
