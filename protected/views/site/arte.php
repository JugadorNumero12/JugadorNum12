<div>
    <h2> Arte original </h2>      

    <div>
        <ul>
        <?php for  ($i=0; $i<=31; $i++) { ?>
           
            <li>    
                <a href="<?php echo Yii::app()->BaseUrl.'/images/Arte/'.$i.'.jpg'; ?>"> 
                    <img 
                      src="<?php echo Yii::app()->BaseUrl.'/images/Arte/'.$i.'.jpg'; ?>" 
                    /> 
                </a>
           </li>
        
        <?php } ?>
        </ul>

</div>
