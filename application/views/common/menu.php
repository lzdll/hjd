<?php foreach ($nav as $v){  ?>
	<?php if ($v['url']) {?>
        <a href="<?=$v['url']?>"><?=$v['name']?></a>
    <?php } else {?>
        <?=$v['name']?>
    <?php }?>
<?php } ?>