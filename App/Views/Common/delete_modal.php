<?php
/** @var Array $dataDeleteModal */
$headline = isset($dataDeleteModal["headline"]) ? $dataDeleteModal["headline"] : "";
$text = isset($dataDeleteModal["text"]) ? $dataDeleteModal["text"] : "";
$deleteBtnId = isset($dataDeleteModal["deleteBtnId"]) ? $dataDeleteModal["deleteBtnId"] : "confirmedDeleteBtn";
$id = isset($dataDeleteModal["id"]) ? $dataDeleteModal["id"] : "deleteModal"
?>

<!-- Modal -->
<div class="modal fade" id="<?=$id?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?=$id?>Label"><?=$headline?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?=$text?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="<?=$deleteBtnId?>">Delete</button>
            </div>
        </div>
    </div>
</div>
