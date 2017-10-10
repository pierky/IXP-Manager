<?php
    /** @var Foil\Template\Template $t */
    $this->layout( 'layouts/ixpv4' );
?>

<?php $this->section( 'title' ) ?>
    <a href="<?= action($t->controller.'@list') ?>">
        <?=  $t->data[ 'feParams' ]->pagetitle  ?>
    </a>
<?php $this->append() ?>

<?php $this->section( 'page-header-postamble' ) ?>
    <li>
        View <?=  $t->data[ 'feParams' ]->titleSingular  ?>
    </li>
<?php $this->append() ?>



<?php $this->section( 'page-header-preamble' ) ?>

    <li class="pull-right">
        <div class="btn-group btn-group-xs" role="group">
            <a type="button" class="btn btn-default" href="<?= action($t->controller.'@list') ?>">
                <span class="glyphicon glyphicon-th-list"></span>
            </a>
            <a type="button" class="btn btn-default" href="<?= action($t->controller.'@edit' , [ 'id' => $t->data[ 'data' ][ 'id' ] ]) ?>">
                <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a type="button" class="btn btn-default" href="<?= action($t->controller.'@add') ?>">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>
    </li>

<?php $this->append() ?>

<?php $this->section('content') ?>

    <?= $t->alerts() ?>

    <?= $t->view['viewPreamble'] ? $t->insert( $t->view['viewPreamble'] ) : '' ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            Details for <?=  $t->data[ 'feParams' ]->titleSingular  ?> <?= !isset( $t->data[ 'data' ]['id'] ) ?: '(DB ID: ' . $t->data[ 'data' ]['id'] . ')' ?>
        </div>

        <div class="panel-body">

            <table class="table_view_info">

                <?php if( isset( $t->data[ 'feParams' ]->viewColumns ) ): ?>

                    <?php foreach( $t->data[ 'feParams' ]->viewColumns as $col => $cconf ): ?>

                        <tr>

                            <?php if( !is_array( $cconf ) || !isset( $cconf[ 'display'] ) || $cconf[ 'display'] ): ?>

                                <th>
                                    <?php if( !is_array( $cconf ) ): ?>
                                        <?= $t->ee( $cconf ) ?>
                                    <?php else: ?>
                                        <?= $t->ee( $cconf[ 'title' ] ) ?>
                                    <?php endif; ?>
                                </th>



                                <td>

                                    <?php if( !is_array( $cconf ) ): ?>

                                        <?php if( $t->data[ 'data' ][ $col ] == false ): ?>
                                            0
                                        <?php else: ?>
                                            <?= $t->ee( $t->data[ 'data' ][ $col ] ) ?>
                                        <?php endif; ?>

                                    <?php elseif( isset( $cconf[ 'type' ] ) ): ?>

                                        <?php if( $cconf[ 'type'] == $t->data[ 'col_types' ][ 'HAS_ONE'] ): ?>

                                            <a href="<?= url( $cconf[ 'controller'] . '/' . $cconf[ 'action'] . '/id/' . $t->data[ 'data' ][ $cconf['idField'] ] ) ?>">
                                                <?= $t->ee( $t->data[ 'data' ][ $col ] ) ?>
                                            </a>

                                        <?php elseif( $cconf[ 'type'] == $t->data[ 'col_types' ][ 'XLATE'] ): ?>

                                            <?php if( isset($cconf[ 'xlator'][ $t->data[ 'data' ][ $col ] ]) ): ?>
                                                <?= $t->ee( $cconf[ 'xlator' ][ $t->data[ 'data' ][ $col] ] ) ?>
                                            <?php else: ?>
                                                <?= $t->ee( $t->data[ 'data' ][ $col ] ) ?>
                                            <?php endif; ?>

                                        <?php elseif( $cconf[ 'type'] ==  $t->data[ 'col_types' ][ 'DATETIME'] ): ?>

                                            <?php if( $t->data[ 'data' ][ $col ] ): ?>
                                                <?= $t->ee( date('Y-m-d H:M:S', strtotime($t->data[ $col ] ) ) ) ?>
                                            <?php endif; ?>

                                        <?php elseif( $cconf[ 'type'] == $t->data[ 'col_types' ][ 'DATE'] ): ?>

                                            <?php if ( $t->data[ 'data' ][ $col ] ): ?>
                                                <?= $t->ee( date('Y-m-d', strtotime( $t->data[ $col ] ) ) ) ?>
                                            <?php endif; ?>

                                        <?php elseif( $cconf[ 'type' ] ==  $t->data[ 'col_types' ][ 'TIME'] ): ?>

                                            <?php if( $t->data[ 'data' ][ $col ] ): ?>
                                                <?= $t->ee( date('H:M:S', strtotime($t->data[ $col ] ) ) ) ?>
                                            <?php endif; ?>

                                        <?php elseif( $cconf[ 'type' ] ==  $t->data[ 'col_types' ][ 'REPLACE'] ): ?>

                                            <?php if( $t->data[ 'data' ][ $col ] ): ?>
                                                <?= str_replace( '%%COL%%', $t->data[ 'data' ][ $col ] , $cconf[ 'subject' ] ) ?>
                                            <?php endif; ?>

                                        <?php elseif( $cconf[ 'type' ] ==  $t->data[ 'col_types' ][ 'YES_NO'] ): ?>

                                            <?= $t->data[ 'data' ][ $col ] ? 'Yes' : 'No' ?>

                                        <?php elseif( $cconf[ 'type'] == $t->data[ 'col_types' ][ 'SCRIPT'] ): ?>

                                            <?= $t->insert( $cconf['script'] ) ?>

                                        <?php else: ?>

                                            Type?

                                        <?php endif; ?>

                                    <?php else: ?>

                                        <?= $t->ee( $t->data[ 'data' ][ $col ] ) ?>

                                    <?php endif; ?>
                                </td>

                            <?php endif; ?>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </table>

        </div>

    </div>

    <?= $t->view['viewPostamble'] ? $t->insert( $t->view['viewPostamble'] ) : '' ?>


<?php $this->append() ?>

<?php $this->section( 'scripts' ) ?>

    <?= $t->view[ 'viewScript' ] ? $t->insert( $t->view[ 'viewScript' ] ) : '' ?>

<?php $this->append() ?>



