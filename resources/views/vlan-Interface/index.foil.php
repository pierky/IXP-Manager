<?php
/** @var Foil\Template\Template $t */

    $this->layout( 'layouts/ixpv4' )
?>

<?php $this->section( 'title' ) ?>
    <a href="<?= url( 'virtual-interface/edit/id/'.$t->vli->getVirtualInterface()->getId())?>">Vlan Interface</a>
<?php $this->append() ?>

<?php $this->section( 'page-header-postamble' ) ?>
    <li>
        Layer 2 Interface : <?= $t->vli->getVlan()->getName()?>
    </li>

    <span class="pull-right">
        <div class="btn-group btn-group-xs" role="group">
            <a type="button" class="btn btn-default" id="add-l2a">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>
    </span>
<?php $this->append() ?>


<?php $this->section( 'content' ) ?>
    <table id='layer-2-interface-list' class="table ">
        <thead>
            <tr>
                <td>Id</td>
                <td>MAC Adress</td>
                <td>Created at</td>
                <td>Action</td>
            </tr>
        <thead>
        <tbody>
            <?php foreach( $t->vli->getLayer2Addresses() as $l2a ):
                /** @var \Entities\PatchPanelPort $ppp */
                ?>
                <tr>
                    <td>
                        <?= $l2a->getId() ?>
                    </td>
                    <td>
                        <?= $l2a->getMac() ?>
                    </td>
                    <td>
                        <?= $l2a->getCreatedAt() ?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a class="btn btn btn-default" href="<?= url( '/patch-panel/view' ).'/'.$l2a->getId()?>" title="Preview">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <a class="btn btn btn-default" href="<?= url( '/patch-panel/edit' ).'/'.$l2a->getId()?>" title="Delete">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach;?>
        <tbody>
    </table>
<?php $this->append() ?>

<?php $this->section( 'scripts' ) ?>
    <script>
        $(document).ready( function() {
            $( '#layer-2-interface-list' ).DataTable({
                "autoWidth": false,
                "columnDefs": [{
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false,
                }],
                "order": [[ 0, "asc" ]]
            });
        } );

        $( "#add-l2a" ).on( 'click', function(e){
            e.preventDefault();
            bootbox.prompt({
                title: "Enter a MAC Address.",
                inputType: 'text',
                callback: function (result) {
                    if(result != null){
                        $.ajax( "<?= url('layer-to-interface/store')?>", {
                            data: {
                                id: <?= $t->vli->getId() ?>,
                                mac: result,
                                _token : "<?= csrf_token() ?>"
                            },
                            type: 'POST'
                        })
                            .done( function( data ) {

                            })
                            .fail( function(){
                                alert( 'Could not update notes. API / AJAX / network error' );
                                throw new Error("Error running ajax query for api/v4/patch-panel-port/notes");
                            })

                    }
                }
            });

        });



    </script>
<?php $this->append() ?>
