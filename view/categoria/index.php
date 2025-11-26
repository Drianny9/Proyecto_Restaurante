<table>
    <tr>
        <td>Id</td>
        <td>Nombre</td>
        <td></td>
    </tr>

    <?php foreach ($listaCategorias as $categoria) { ?>
            <tr>
               <td><?=$categoria->getIdCategoria();?></td>
               <td><?=$categoria->getNombre();?></td>
                <td><a href="?controller=Categoria&action=show&id_categoria=<?=$categoria->getIdCategoria();?>">link</a></td>
            </tr>
        <?php } ?>
       
</table>