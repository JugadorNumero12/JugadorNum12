<div>
    <h2> Arte original </h2>      

    <?php for  ($i=0; $i<=31; $i++) { ?>
        <tr>
            <td><img src="<?php echo Yii::app()->BaseUrl.'/images/Arte/'.$i.'.jpg'; ?>"</td>
        </tr>
    <?php } ?>

</div>