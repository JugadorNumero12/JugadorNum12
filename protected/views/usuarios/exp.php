<!-- array -->
<div>
<table>
     <tr>
       <td>Nivel</td>
       <td>Exp Necesaria</td>
     </tr>
     <?php for ($i = 0; $i < 100; $i++) { ?>
     <tr>
       <td><?php echo $i; ?></td>
       <td><?php echo $array[$i]; ?></td>
     </tr>
     <?php } ?>
</table>
</div>