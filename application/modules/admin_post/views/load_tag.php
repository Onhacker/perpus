<?php  
$crk = explode(',', $rec->tag);
foreach ($tag->result() as $tag) : 
 $_ck = (array_search($tag->tag_seo, $crk) === false)? '' : 'checked'; ?>
    <li class="list-group-item border-0 pl-1">
        <div class="checkbox checkbox-primary">
            <input class="todo-done" id="<?php echo $tag->tag_seo ?>" value="<?php echo $tag->tag_seo ?>" name="tag[]"  type="checkbox" <?php echo $_ck ?>><label for="<?php echo $tag->tag_seo ?>"><?php echo $tag->nama_tag ?></label>
            <?php $cek = $this->om->engine_akses_menu("Admin_tag",$this->session->userdata("admin_session")); 
            if($cek == 1 OR $this->session->userdata("admin_level") == "admin"){ ?>
            	<span class="float-right" style="cursor: pointer;" onclick="hapus_tag(<?php echo $tag->id_tag ?>)"><i class="fa fa-trash"></i></span>
            <?php } ?>

             
        </div>

    </li>
<?php endforeach ?>
