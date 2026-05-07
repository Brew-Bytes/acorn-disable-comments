<?php

declare(strict_types=1);

namespace BrewAndBytes\AcornDisableComments\Modules;

use WP_Admin_Bar;

class AdminUiModule extends AbstractModule
{
    public function handle(): void
    {
        if (! $this->enabled()) {
            return;
        }

        if ($this->config->get('menu', true)) {
            $this->action('admin_menu', 'removeAdminMenu', 9999);
        }

        if ($this->config->get('admin-bar', true)) {
            $this->action('admin_bar_menu', 'removeAdminBarNode', 999);
        }

        if ($this->config->get('dashboard-widget', true)) {
            $this->action('wp_dashboard_setup', 'removeDashboardWidget');
        }

        if ($this->config->get('list-table-columns', true)) {
            $this->action('admin_init', 'removeCommentsColumns');
        }

        if ($this->config->get('discussion-settings', true)) {
            $this->action('admin_menu', 'removeDiscussionSubmenu', 9999);
        }

        if ($this->config->get('redirect-direct-visits', true)) {
            $this->action('admin_init', 'redirectAwayFromCommentScreens');
        }
    }

    public function removeAdminMenu(): void
    {
        remove_menu_page('edit-comments.php');
    }

    public function removeAdminBarNode(WP_Admin_Bar $wpAdminBar): void
    {
        $wpAdminBar->remove_node('comments');
    }

    public function removeDashboardWidget(): void
    {
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    }

    public function removeCommentsColumns(): void
    {
        foreach (get_post_types() as $postType) {
            add_filter("manage_edit-{$postType}_columns", [$this, 'unsetCommentsColumn']);
        }
    }

    /**
     * @param  array<string, string>  $columns
     * @return array<string, string>
     */
    public function unsetCommentsColumn(array $columns): array
    {
        unset($columns['comments']);

        return $columns;
    }

    public function removeDiscussionSubmenu(): void
    {
        remove_submenu_page('options-general.php', 'options-discussion.php');
    }

    public function redirectAwayFromCommentScreens(): void
    {
        global $pagenow;

        if (! isset($pagenow)) {
            return;
        }

        if (in_array($pagenow, ['edit-comments.php', 'comment.php', 'options-discussion.php'], true)) {
            wp_safe_redirect(admin_url(), 302);
            exit;
        }
    }
}
