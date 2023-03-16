<?php require_once ViewDir."/template/header.php"?>


<h1>Item list</h1>
<?php
//
//dd($lists);
//?>
<!--<div class="d-flex justify-content-center">-->
<!--    <a href="--><?//= route("list")?><!--" class="btn btn-outline-primary">All List</a>-->
<!--</div>-->

<div class="border rounded p-5">
    <form action="<?= route("inventory-edit")?>" method="post">
        <input type="hidden" name="_method" value="put">
        <input type="hidden" name="id" value="<?=$list['id'] ?>">
        <div class="row align-items-end">
            <div class="col-3">
                <label for="" class="form-label">Item Name</label>
                <input type="text" name="name" value="<?=$list["name"]?>" class="form-control" required>
            </div>
            <div class="col-3">
                <label for="" class="form-label">Price</label>
                <input type="number" name="price" value="<?=$list["price"]?>" class="form-control" required>
            </div>
            <div class="col-3">
                <label for="" class="form-label">Stock</label>
                <input type="number" name="stock" value="<?=$list["stock"]?>" class="form-control" required>
            </div>

            <div class="col-3">

                <button class="btn btn-lg btn-primary w-100">Update</button>

            </div
        </div>
    </form>
</div>



<?php require_once ViewDir."/template/footer.php"?>
