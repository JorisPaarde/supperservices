<?php 
namespace App\Includes\Woocommerce;

class AccountMenu 
{    
    protected array $customEndpoints;

    protected array $removeMenuItems;

    public function __construct(array $newEndpoints, array $removeMenuItems = [])
    {
        $this->customEndpoints = $newEndpoints;
        $this->removeMenuItems = $removeMenuItems;

        add_action('init', [$this, 'registerEndpoints']);  
        add_filter('woocommerce_account_menu_items', [$this, 'removeAddAccountLinks']);
        add_filter('woocommerce_get_query_vars', [$this, 'setCustomQueryVars'], 0);

        $this->setTemplates();
    }

    public function registerEndpoints(): void 
    {
        foreach ($this->customEndpoints as $endpoint) {
            if ($this->includeItem($endpoint)) {
                add_rewrite_endpoint($endpoint['key'], EP_PAGES);
            }
        };
        
        flush_rewrite_rules();
    }  

    public function setCustomQueryVars(array $vars): array 
    {
        foreach ($this->customEndpoints as $endpoint) {
            if ($this->includeItem($endpoint)) {
                $vars[$endpoint['key']] = $endpoint['key'];
            }
        };
    
        return $vars;
    }

    public function removeAddAccountLinks(array $menu_links): array 
    {
        if ($this->removeMenuItems) {
            foreach ($this->removeMenuItems as $menuItem) {
                unset($menu_links[$menuItem]);
            }
        }
    
        foreach ($this->customEndpoints as $endpoint) {
            if ($this->includeItem($endpoint)) {
                $menu_links[$endpoint['key']] = $endpoint['title'];
            }
        }

        return $menu_links;
    }

    public function includeItem(array $endpoint): bool
    {
        return isset($endpoint['conditional']) && $endpoint['conditional'] || !isset($endpoint['conditional']);
    }

    public function setTemplates(): void
    {
        foreach ($this->customEndpoints as $endpoint) {
            add_action("woocommerce_endpoint_{$endpoint['key']}_title", function () use ($endpoint) {
                return $endpoint['title'];
            });
        
            add_action("woocommerce_account_{$endpoint['key']}_endpoint", function () use ($endpoint) {
                echo \App\template($endpoint['template']);
            });
        };
    }
}
