function DeleteUserYesOrNo(){
    const response = confirm("Voulez vous vraiment supprimer ce compte?");
    if (response) {
        location.href = "../pages/account.php?delete";
    }
}

