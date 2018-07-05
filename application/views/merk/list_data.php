<?php
  $no = 1;
  foreach ($dataMerk as $merk) {
    ?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $merk->nama_merk; ?></td>
      <td class="text-center" style="min-width:230px;">
          <button class="btn btn-warning update-dataMerk" data-id="<?php echo $merk->id; ?>"><i class="glyphicon glyphicon-repeat"></i> Update</button>
          <button class="btn btn-danger konfirmasiHapus-merk" data-id="<?php echo $merk->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>
          <button class="btn btn-info detail-dataMerk" data-id="<?php echo $merk->id; ?>"><i class="glyphicon glyphicon-info-sign"></i> Detail</button>
      </td>
    </tr>
    <?php
    $no++;
  }
?>