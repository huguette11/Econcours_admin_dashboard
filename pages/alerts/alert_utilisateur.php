<?php
if (empty($_SESSION['id']))
{       
  header('Location:../../index.php?erreur=3'); 
}
?>
<?php
if (isset($_SESSION['mod']) && $_SESSION['mod'] ==1)
{ 
    ?>
<script>
Swal.fire(
  'Utilisateur modifié!',
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
  'Utilisateur supprimé!',
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
  'Utilisateur enregistré!',
  'Cliquez sur OK pour continuer',
  'success'
)
</script>
<?php $_SESSION['ajout']=0;
} ?>
<?php
if (isset($_SESSION['imp']) && $_SESSION['imp'] ==1)
{ 
    ?>
<script>
Swal.fire(
  'Un utilisateur possède déja ce nom d\'utilisateur!',
  'Cliquez sur OK pour continuer',
  'error'
)
</script>
<?php $_SESSION['imp']=0;
} ?>

