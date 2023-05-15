/**
 * fonction qui permet d'afficher une popup qui demande à l'utilisateur s'il veut vraiment supprimer son compte
 */
function DeleteUserYesOrNo(){
    const response = confirm("Voulez vous vraiment supprimer ce compte?");
    if (response) {
        location.href = "../pages/account.php?delete";
    }
}



