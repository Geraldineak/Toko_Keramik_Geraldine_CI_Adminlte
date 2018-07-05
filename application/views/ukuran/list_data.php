<?php
  $no = 1;
  foreach ($dataUkuran as $ukuran) {
    ?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $ukuran->ukuran; ?></td>
      <td class="text-center" style="min-width:230px;">
        <button class="btn btn-warning update-dataPosisi" data-id="<?php echo $ukuran->id; ?>"><i class="glyphicon glyphicon-repeat"></i> Update</button>
        <button class="btn btn-danger konfirmasiHapus-posisi" data-id="<?php echo $ukuran->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>
        <button class="btn btn-info detail-dataPosisi" data-id="<?php echo $ukuran->id; ?>"><i class="glyphicon glyphicon-info-sign"></i> Detail</button>
      </td>
    </tr>
    <?php
    $no++;
  }
?>