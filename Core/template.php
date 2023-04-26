<?php if(isset($scope)): ?>
<!-- User is defined and is not null-->
<?=  "first isset :".$scope[0]["id"]."<br>"  ?>
<?php endif; ?>
<?php if(isset($scope[0]["email"])): ?>
<!-- User is defined and is not null-->
<?=  "second isset :".$scope[0]["email"]."<br>" ?>
<?php endif; ?>

<?php foreach($scope as $sc): ?>
<?php foreach($sc as $s): ?>
<?= $s."<br>" ?>
<?php endforeach; ?>
<?php endforeach; ?>

