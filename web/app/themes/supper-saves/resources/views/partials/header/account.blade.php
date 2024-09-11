@php
global $current_user;
wp_get_current_user();
@endphp

<dropdown>
    <template v-slot:trigger>
        <icon icon="user"></icon>
    </template>
    <template v-slot:items>
        @if (is_user_logged_in())
            <dropdown-item
                link="{{ wc_get_page_permalink('myaccount') }}"
            >
                <?php echo __('My profile', 'supper'); ?>
            </dropdown-item>
            <hr class="h-0.5 bg-white border-none">
            <dropdown-item
                link="{{ wc_get_account_endpoint_url('hardware') }}"
            >
                <?php echo __('Hardware', 'supper'); ?>
            </dropdown-item>
            <hr class="h-0.5 bg-white border-none">
            <dropdown-item
                link="{{ wc_get_account_endpoint_url('support') }}"
            >
                <?php echo __('SUPPER support', 'supper'); ?>
            </dropdown-item>
            <hr class="h-0.5 bg-white border-none">
            <dropdown-item
                link="{{ home_url('faq') }}"
            >
                <?php echo __('FAQ', 'supper'); ?>
            </dropdown-item>
            <hr class="h-0.5 bg-white border-none">
            <dropdown-item
                link="{{ wc_logout_url() }}"
            >
                <?php echo __('Log out', 'supper'); ?>
                <icon icon="log-out" class="ml-auto"></icon>
            </dropdown-item>
        @else
            <form
                class="woocommerce-form woocommerce-form-login w-[320px] login py-5 px-6 mb-0"
                method="post"
            >
                <?php do_action('woocommerce_login_form_start'); ?>

                <div class="form-row">
                    <label
                        for="username"
                        class="form-label"
                    >
                        <?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-input"
                        name="username"
                        id="username"
                        autocomplete="username"
                        value="<?php echo !empty($_POST['username']) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"
                    />
                </div>
                <div class="form-row">
                    <label
                        for="password"
                        class="form-label"
                    >
                        <?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span>
                    </label>
                    <input
                        class="form-input"
                        type="password"
                        name="password"
                        id="password"
                        autocomplete="current-password"
                    />
                </div>

                <?php do_action('woocommerce_login_form'); ?>

                <div class="form-row">
                    <label class="form-label">
                        <input
                            class="form-checkbox mr-3"
                            name="rememberme"
                            type="checkbox"
                            id="rememberme"
                            value="forever"
                        />
                        <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                    </label>
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                    <div class="flex justify-between items-center mt-4">
                        <button
                            type="submit"
                            class="woocommerce-button button button-white woocommerce-form-login__submit"
                            name="login"
                            value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"
                        >
                            <?php esc_html_e('Log in', 'woocommerce'); ?>
                        </button>
                        <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text-base">
                            <?php esc_html_e('Lost your password?', 'woocommerce'); ?>
                        </a>
                    </div>
                </div>
                <?php do_action('woocommerce_login_form_end'); ?>
                <p class="text-base text-center mt-3">
                    <?php echo __('New to SUPPER?', 'supper');?>
                    <a href="{{ wc_get_account_endpoint_url('dashboard') }}" class="underline block">
                        <?php echo __('Click here to register', 'supper');?>
                    </a>
                </p>
            </form>
        @endif
    </template>
</dropdown>
