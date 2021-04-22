<form action="<?php echo base_url(); ?>website/user/User_account/submit_edit_password" method="post">
<input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
 <input type="hidden" id="id" name="id" value="<?=$data_user->id?>" style="display: none">
  <div class="form-group">
  
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="<?=$data_user->username?>" readonly="true">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Ubah Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" >
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>