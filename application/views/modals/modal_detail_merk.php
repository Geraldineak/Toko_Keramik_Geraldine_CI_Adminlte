<div class="col-md-12 well">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;"><i class="fa fa-location-arrow"></i> List Pegawai (Dari Kota: <b><?php echo $kota->nama; ?></b>)</h3>

  <div class="box box-body">
      <table id="tabel-detail" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Ukuran</th>
          </tr>
        </thead>
        <tbody id="data-stok">
          <?php
            foreach ($dataMerk as $data_stok_barang) {
              ?>
              <tr>
                <td style="min-width:230px;"><?php echo $data_stok_barang->data_stok_barang; ?></td>
                <td><?php echo $data_stok_barang->merk; ?></td>
                <td><?php echo $data_stok_barang->ukuran; ?></td>
              </tr>
              <?php
            }
          ?>
        </tbody>
      </table>
  </div>

  <div class="text-right">
    <button class="btn btn-danger" data-dismiss="modal"> Close</button>
  </div>
</div>