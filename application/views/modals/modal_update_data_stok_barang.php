<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
  <div class="form-msg"></div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;">Update Data Stok Barang</h3>
      <form method="POST" id="form-update-pegawai">
        <input type="hidden" name="id" value="<?php echo $dataPegawai->id_pegawai; ?>">
        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" placeholder="Nama" name="nama_barang" aria-describedby="sizing-addon2" value="<?php echo $dataDataStokBarang->nama_barang; ?>">
        </div>
        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-home"></i>
          </span>
          <select name="merk" class="form-control select2"  aria-describedby="sizing-addon2">
            <?php
            foreach ($dataMerk as $merk) {
              ?>
              <option value="<?php echo $merk->id; ?>" <?php if($merk->id == $dataMerk->id_merk){echo "selected='selected'";} ?>><?php echo $merk->nama_merk; ?></option>
              <?php
            }
            ?>
          </select>
        </div>
        <!-- <div class="input-group form-group" style="display: inline-block;">
          <span class="input-group-addon" id="sizing-addon2">
          <i class="glyphicon glyphicon-tag"></i>
          </span>
          <span class="input-group-addon">
              <input type="radio" name="jk" value="1" id="laki" class="minimal" <?php if($dataPegawai->id_kelamin == 1){echo "checked='checked'";} ?>>
          <label for="laki">Laki-laki</label>
            </span>
            <span class="input-group-addon">
              <input type="radio" name="jk" value="2" id="perempuan" class="minimal" <?php if($dataPegawai->id_kelamin == 2){echo "checked='checked'";} ?>> 
          <label for="perempuan">Perempuan</label>
            </span>
        </div> -->
        <div class="input-group form-group">
          <span class="input-group-addon" id="sizing-addon2">
            <i class="glyphicon glyphicon-briefcase"></i>
          </span>
          <select name="ukuran" class="form-control select2"  aria-describedby="sizing-addon2">
            <?php
            foreach ($dataUkuran as $ukuran) {
              ?>
              <option value="<?php echo $ukuran->id; ?>" <?php if($ukuran->id == $dataDataStokBarang->id_ukuran){echo "selected='selected'";} ?>><?php echo $ukuran->ukuran; ?></option>
              <?php
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <div class="col-md-12">
              <button type="submit" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Update Data</button>
          </div>
        </div>
      </form>
</div>

<script type="text/javascript">
$(function () {
    $(".select2").select2();

    // $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    //   checkboxClass: 'icheckbox_flat-blue',
    //   radioClass: 'iradio_flat-blue'
    // });
});
</script>