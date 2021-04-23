<div class="isi-content">
  <div class="row">
      <div class="col-sm-12">
      <form action="<?php echo base_url(); ?>website/user/User_account/submit_edit_account" method="post">
        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
        <input type="hidden" id="id" name="id" value="<?=$data_user->id?>" style="display: none">
        <input type="hidden" id="id_peserta" name="id_peserta" value="<?=$data_user->peserta_id?>" style="display: none">
        <div class="form-group">
          <label for="name">Nama</label>
          <input id="name" class="form-control" type="text" name="name" placeholder="Masukkan Nama Anda" onkeypress="return /[a-zA-Z ]/i.test(event.key)" value="<?=$data_user->peserta_name?>" required>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="<?=$data_user->username?>" readonly="true" required>
        </div>
        <div class="form-group">
          <label for="phoneNumber">No Telp</label>
          <input id="phoneNumber" class="form-control" type="tel" name="phone" placeholder="Nomor Telp Aktif. Ex : 085823445xxx" onkeypress="return /[0-9]/i.test(event.key)" minlength="10" maxlength="13" pattern=".{10,13}" title="Minimal 10 Angka Maksimal 13 Angka" value="<?=$data_user->no_telp?>" required>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" value="<?=$this->encryption->decrypt($data_user->password)?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
      </div>
  </div>