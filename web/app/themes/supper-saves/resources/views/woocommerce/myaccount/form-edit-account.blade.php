@php do_action('woocommerce_before_edit_account_form'); @endphp

<form
    class="woocommerce-EditAccountForm edit-account"
    action=""
    method="post"
    @php do_action('woocommerce_edit_account_form_tag'); @endphp
>
    @php do_action('woocommerce_edit_account_form_start'); @endphp

    <div class="grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-10">
        <p class="form-row form-row-first">
            <label for="account_first_name">
                <?php esc_html_e('First name', 'woocommerce'); ?>
            </label>
            <input
                type="text"
                class="input-text"
                name="account_first_name"
                id="account_first_name"
                autocomplete="given-name"
                value="<?php echo esc_attr($user->first_name); ?>"
            />
        </p>
        <p class="form-row form-row-last">
            <label for="account_last_name">
                <?php esc_html_e('Last name', 'woocommerce'); ?>
            </label>
            <input
                type="text"
                class="input-text"
                name="account_last_name"
                id="account_last_name"
                autocomplete="family-name"
                value="<?php echo esc_attr($user->last_name); ?>"
            />
        </p>
    </div>
    <p class="form-row">
        <label for="account_display_name">
            <?php esc_html_e('Display name', 'woocommerce'); ?>
        </label>
        <input
            type="text"
            class="input-text"
            name="account_display_name"
            id="account_display_name"
            value="<?php echo esc_attr($user->display_name); ?>"
        /> <span><em><?php esc_html_e('This will be how your name will be displayed in the account section and in reviews', 'woocommerce'); ?></em></span>
    </p>
    <p class="form-row">
        <label for="account_display_name">
            <?php esc_html_e('Username', 'woocommerce'); ?>
        </label>
        <input
            type="text"
            class="input-text"
            name="account_nickname"
            id="account_nickname"
            value="<?php echo esc_attr($user->user_login); ?>"
        />
    </p>

    <p class="form-row">
        <label for="account_email">
            <?php esc_html_e('Email address', 'woocommerce'); ?>
        </label>
        <input
            type="email"
            class="input-text"
            name="account_email"
            id="account_email"
            autocomplete="email"
            value="<?php echo esc_attr($user->user_email); ?>"
        />
    </p>

    <fieldset class="mt-4">
        <h2 class="text-xl"><?php esc_html_e('Password change', 'woocommerce'); ?></h2>

        <p class="form-row">
            <label for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
            <input
                type="password"
                class="input-text"
                name="password_current"
                id="password_current"
                autocomplete="off"
            />
        </p>
        <p class="form-row">
            <label for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
            <input
                type="password"
                class="input-text"
                name="password_1"
                id="password_1"
                autocomplete="off"
            />
        </p>
        <p class="form-row">
            <label for="password_2"><?php esc_html_e('Confirm new password', 'woocommerce'); ?></label>
            <input
                type="password"
                class="input-text"
                name="password_2"
                id="password_2"
                autocomplete="off"
            />
        </p>
    </fieldset>

    @php do_action('woocommerce_edit_account_form'); @endphp

    <p class="mt-4">
        <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
        <button
            type="submit"
            class="button"
            name="save_account_details"
        >
            <?php esc_html_e('Save changes', 'woocommerce'); ?>
        </button>
        <input
            type="hidden"
            name="action"
            value="save_account_details"
        />
    </p>

    @php do_action('woocommerce_edit_account_form_end'); @endphp
</form>

@php do_action('woocommerce_after_edit_account_form'); @endphp
