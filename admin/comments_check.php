<?php
if (!defined('OC_ADMIN')) {
    exit('Direct access is not allowed.');
}
if (!osc_is_admin_user_logged_in()) {
    die;
}

$sp     = new spam_prot;
$params = Params::getParamsAsArray();

if (isset($params['action']) && is_numeric($params['id'])) {
    $sp->_spamActionComments($params['action'], $params['id']);
}
?>
<div class="compare table-contains-actions" id="spamprot">
    <table class="table" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th class="col-status-border "></th>
            <th class="col-status "><?php _e('Status', 'spamprotection'); ?></th>
            <th class="col-author "><?php _e('Author', 'spamprotection'); ?></th>
            <th class="col-comment "><?php _e('Reason', 'spamprotection'); ?></th>
            <th class="col-date sorting_desc"><?php _e('Date', 'spamprotection'); ?></th>
        </tr>
        </thead>
        <tbody>

        <?php
        $comments = $sp->_getResult('t_sp_comments');

        foreach ($comments as $key => $value) {
            $user = User::newInstance()->findByPrimaryKey($value['fk_i_user_id']);
            echo '
                    <tr class="status-blocked">
                        <td class="col-status-border"></td>
                        <td class="col-status">' . __('blocked', 'spamprotection') . '</td>
                        <td class="col-author">
                            <a href="' . osc_admin_base_url(true) . '?page=users&action=edit&id=' . $user['pk_i_id']
                . '">' . $user['s_name'] . '</a>
                            <div class="actions">
                                <ul>
                                    <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__DIR__)
                    . 'admin/comments_view.php?id=' . $value['pk_i_id']) . '">' . __('View', 'spamprotection') . '</a></li>
                                    <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__DIR__)
                    . 'admin/comments_check.php?action=activate&id=' . $value['pk_i_id']) . '">' . __('Activate',
                    'spamprotection') . '</a></li>
                                    <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__DIR__)
                    . 'admin/comments_check.php?action=delete&id=' . $value['pk_i_id']) . '">' . __('Delete',
                    'spamprotection') . '</a></li>
                                </ul>
                            </div>
                        </td>
                        <td class="col-comment">' . $value['s_reason'] . '</td>
                        <td class="col-date">' . $value['dt_date'] . '</td>
                    </tr>
                    ';
        }
        ?>
        </tbody>
    </table>

</div>
