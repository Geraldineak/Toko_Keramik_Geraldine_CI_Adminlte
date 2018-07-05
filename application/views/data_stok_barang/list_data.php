<?php
  foreach ($dataDataStokBarang as $data_stok_barang) {
    ?>
    <tr>
      <td style="min-width:230px;"><?php echo $data_stok_barang->data_stok_barang; ?></td>
      <td><?php echo $data_stok_barang->nama_merk; ?></td>
      <td><?php echo $data_stok_barang->ukuran; ?></td>
      <td><?php echo $data_stok_barang->warna; ?></td>
      <td class="text-center" style="min-width:230px;">
        <button class="btn btn-warning update-dataDataStokBarang" data-id="<?php echo $data_stok_barang->id; ?>"><i class="glyphicon glyphicon-repeat"></i> Update</button>
        <button class="btn btn-danger konfirmasiHapus-data_stok_barang" data-id="<?php echo $data_stok_barang->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>
      </td>
    </tr>
    <?php
  }
?>