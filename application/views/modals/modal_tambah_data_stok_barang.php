<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
  <div class="form-msg"></div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;">Tambah Data Stok Barang</h3>

  <form id="form-tambah-stok" method="POST">
    <div class="input-group form-group">
      <span class="input-group-addon" id="sizing-addon2">
        <i class="glyphicon glyphicon-user"></i>
      </span>
      <input type="text" class="form-control" placeholder="Nama" name="nama" aria-describedby="sizing-addon2">
    </div>
    <div class="input-group form-group">
      <span class="input-group-addon" id="sizing-addon2">
        <i class="glyphicon glyphicon-home"></i>
      </span>
      <select name="merk" class="form-control select2" aria-describedby="sizing-addon2">
        <?php
        foreach ($dataMerk as $merk) {
          ?>
          <option value="<?php echo $merk->id; ?>">
            <?php echo $merk->nama_merk; ?>
          </option>
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
          <input type="radio" name="ukuran" value="1" id="small" class="minimal">
      <label for="small">20x20</label>
        </span>
        <span class="input-group-addon">
          <input type="radio" name="ukuran" value="2" id="medium" class="minimal"> 
      <label for="medium">40x40</label>
        <span class="input-group-addon">
          <input type="radio" name="ukuran" value="3" id="large" class="minimal"> 
      <label for="large">60x60</label>
        </span>
    </div> -->
    <div class="input-group form-group">
      <span class="input-group-addon" id="sizing-addon2">
        <i class="glyphicon glyphicon-briefcase"></i>
      </span>
      <select name="ukuran" class="form-control select2"  aria-describedby="sizing-addon2" style="width: 100%">
        <?php
        foreach ($dataUkuran as $ukuran) {
          ?>
          <option value="<?php echo $ukuran->id; ?>">
            <?php echo $ukuran->ukuran; ?>
          </option>
          <?php
        }
        ?>
      </select>
    </div>
    <div class="form-group">
      <div class="col-md-12">
          <button type="submit" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Tambah Data</button>
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