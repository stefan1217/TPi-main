/**
 * fonction qui permet d'ajouter deux aliments malsains dans la liste
 */
export function addBadFood(list) {
    list.push({ category: "malbouffe", name: "Fausse-tomate", picture_path: "Fausse-tomate.png" });
    list.push({ category: "malbouffe", name: "Fausse-aubergine", picture_path: "Fausse-aubergine.png" });
}