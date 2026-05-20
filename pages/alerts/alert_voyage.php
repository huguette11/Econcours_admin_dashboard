<!--Script affichant les sweat alert-->
<?php
if (empty($_SESSION['id']))
{       
  header('Location:../index.php?erreur=3'); 
}
?>
<?php
if (isset($_SESSION['mod']) && $_SESSION['mod'] ==1)
{ 
    ?>
<script>
Swal.fire(
  'Voyage modifié!',
  'Cliquez sur OK pour continuer',
  'success'
)
</script> 
<?php $_SESSION['mod']=0;
} ?>
<?php
if (isset($_SESSION['supr']) && $_SESSION['supr']==1)
{?>
<script>
Swal.fire(
  'Voyage supprimé!',
  'Cliquez sur OK pour continuer',
  'success'
)
</script> 
<?php $_SESSION['supr']=0;
} ?>

<?php
if (isset($_SESSION['ajout']) && $_SESSION['ajout'] ==1)
{ 
    ?>
<script>
Swal.fire(
  'Voyage enregistré!',
  'Cliquez sur OK pour continuer',
  'success'
)
</script>
<?php $_SESSION['ajout']=0;
} ?>


