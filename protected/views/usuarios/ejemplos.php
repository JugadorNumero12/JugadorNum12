<!-- ultras, empresarios, chicas -->
<div>
  <h3>ULTRAS</h3>
<table>
     <tr>
       <th>Nivel</th>
       <th>Generacion Dinero </th>
       <th>Generacion Animo </th>
       <th>Generacion Influencias </th>
       <th>Animo MAX </th>
       <th>Influencias MAX </th>
     </tr>
     <?php foreach ($ultras as $p) { ?>
     <tr>
       <td><?php echo $p->nivel; ?></td>
       <td><?php echo $p->recursos->dinero_gen; ?></td>
       <td><?php echo $p->recursos->animo_gen; ?></td>
       <td><?php echo $p->recursos->influencias_gen; ?></td>
       <td><?php echo $p->recursos->animo_max; ?></td>
       <td><?php echo $p->recursos->influencias_max; ?></td>
     </tr>
     <?php } ?>
</table>
</div>

<div>
  <h3>CHICAS</h3>
<table>
     <tr>
       <th>Nivel</th>
       <th>Generacion Dinero </th>
       <th>Generacion Animo </th>
       <th>Generacion Influencias </th>
       <th>Animo MAX </th>
       <th>Influencias MAX </th>
     </tr>
     <?php foreach ($chicas as $p) { ?>
     <tr>
       <td><?php echo $p->nivel; ?></td>
       <td><?php echo $p->recursos->dinero_gen; ?></td>
       <td><?php echo $p->recursos->animo_gen; ?></td>
       <td><?php echo $p->recursos->influencias_gen; ?></td>
       <td><?php echo $p->recursos->animo_max; ?></td>
       <td><?php echo $p->recursos->influencias_max; ?></td>
     </tr>
     <?php } ?>
</table>
</div>

<div>
  <h3>EMPREASRIO</h3>
<table>
     <tr>
       <th>Nivel</th>
       <th>Generacion Dinero </th>
       <th>Generacion Animo </th>
       <th>Generacion Influencias </th>
       <th>Animo MAX </th>
       <th>Influencias MAX </th>
     </tr>
     <?php foreach ($empresarios as $p) { ?>
     <tr>
       <td><?php echo $p->nivel; ?></td>
       <td><?php echo $p->recursos->dinero_gen; ?></td>
       <td><?php echo $p->recursos->animo_gen; ?></td>
       <td><?php echo $p->recursos->influencias_gen; ?></td>
       <td><?php echo $p->recursos->animo_max; ?></td>
       <td><?php echo $p->recursos->influencias_max; ?></td>
     </tr>
     <?php } ?>
</table>
</div>