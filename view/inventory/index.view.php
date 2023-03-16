<?php require_once ViewDir."/template/header.php"?>


<h1>Item list</h1>
<?php
//
//dd($lists);
//?>
<div class="d-flex justify-content-between">
    <a href="<?=route("inventory-create")?>" class="btn btn-outline-primary">Create New</a>
    <form action="" method="get">
        <div class=" input-group">
            <input type="text" name="q" value="<?php if (isset($_GET['q'])) : ?> <?= $_GET["q"] ?> <?php endif; ?>" class=" form-control">
            <?php if (isset($_GET['q'])) : ?>
                <a href="<?= route("inventory") ?>" class=" btn btn-danger">
                    Del
                </a>
            <?php endif; ?>
            <button class=" btn btn-primary">Search</button>
        </div>
    </form>
</div>

<table class="table table-bordered my-5">
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Action</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($lists["data"] as $list): ?>
        <tr>
            <td><?=$list["id"] ?></td>
            <td><?=filter($list["name"]) ?></td>
            <td><?=$list["price"] ?></td>
            <td><?=$list["stock"] ?></td>
            <td>
                <a href="<?= route("inventory-update",["id"=>$list['id']]);?>" class="btn btn-sm btn-outline-info">Edit</a>
                <form action="<?= route("inventory-delete",["id"=>$list['id']]);?>" method="post" class="d-inline-block">
                    <input type="hidden" name="_method" value="delete">
                    <input type="hidden" name="id" value="<?= $list['id']?>">
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>

            </td>
            <td><?=$list["created_at"] ?></td>
        </tr>

        <?php endforeach; ?>

    </tbody>
</table>

<!--<div class='d-flex justify-content-between'>-->
<!--    <p class=' mb-0'>Total: --><?//= $lists['total'] ?><!--</p>-->
<!--    <nav>-->
<!--        <ul class='pagination'>-->
<!--        --><?php //foreach ($lists['links'] as $link ): ?>
<!--            <li class='page-item'><a class='page-link --><?//= $link['is_active'] ?><!--' href='--><?//= $link['url'] ?><!--'>--><?//= $link['page_number']?><!--</a></li>-->
<!--        --><?php //endforeach; ?>
<!---->
<!--        </ul>-->
<!--    </nav>-->
<!--</div>-->

<?= paginator($lists);?>

<?php require_once ViewDir."/template/footer.php"?>
