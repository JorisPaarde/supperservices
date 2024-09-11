@php do_action('woocommerce_before_customer_login_form'); @endphp
<div class="grid grid-cols-2 gap-10">
    <div class="h-full col-span-2 lg:col-span-1 p-5 lg:p-12 bg-carousel-pink">
        <h2 class="text-2xl md:text-3xl mb-10"><?php esc_html_e('Login', 'woocommerce'); ?></h2>
        <form
            class="woocommerce-form woocommerce-form-login login"
            method="post"
        >
            <?php do_action('woocommerce_login_form_start'); ?>

            <div class="form-row">
                <label
                    for="username"
                    class="form-label"
                >
                    <?php esc_html_e('Email address', 'woocommerce'); ?>
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
                    <?php esc_html_e('Password', 'woocommerce'); ?>
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
                <label class="form-label flex items-center">
                    <input
                        class="form-checkbox"
                        name="rememberme"
                        type="checkbox"
                        id="rememberme"
                        value="forever"
                    />
                    <span class="ml-2"><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                </label>
                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
            </div>
            <div class="form-row flex flex-col md:flex-row items-start md:items-center">
                <button
                    type="submit"
                    class="woocommerce-button button-outline button-outline-heavy-metal woocommerce-form-login__submit"
                    name="login"
                    value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"
                >
                    <?php esc_html_e('Log in', 'woocommerce'); ?>
                </button>
                <p class="woocommerce-LostPassword lost_password md:ml-auto">
                    <a
                        href="<?php echo esc_url(wp_lostpassword_url()); ?>"
                        class="text-xl"
                    >
                        <?php esc_html_e('Lost your password?', 'woocommerce'); ?>
                    </a>
                </p>
            </div>
            <?php do_action('woocommerce_login_form_end'); ?>

        </form>
    </div>

    @if (get_option('woocommerce_enable_myaccount_registration') === 'yes')
        <div class="h-full col-span-2 lg:col-span-1 p-5 lg:p-12 bg-carousel-pink">
            <h2 class="text-2xl md:text-3xl mb-10"><?php esc_html_e('Register', 'woocommerce'); ?></h2>
            <form
                method="post"
                class="woocommerce-form woocommerce-form-register register"
                @php do_action('woocommerce_register_form_tag'); @endphp
            >
                @php do_action('woocommerce_register_form_start'); @endphp
                <div class="grid grid-cols-2 lg:gap-4 mb-4 lg:mb-0">
                    <div class="form-row form-row-first col-span-2 lg:col-span-1">
                        <label for="reg_billing_company">
                            <?php echo __('Company name', 'woocommerce'); ?>
                        </label>
                        <input
                            type="text"
                            class="input-text"
                            name="billing_company"
                            id="reg_billing_company"
                            required
                            value="{{ !empty($_POST['billing_company']) ? $_POST['billing_company'] : '' }}"
                        />
                    </div>
                    <div class="form-row form-row-first col-span-2 lg:col-span-1">
                        <label for="reg_billing_coc">
                            <?php echo __('COC number', 'woocommerce'); ?>
                        </label>
                        <input
                            type="text"
                            class="input-text"
                            name="billing_coc"
                            id="reg_billing_coc"
                            required
                            value="{{ !empty($_POST['billing_coc']) ? $_POST['billing_coc'] : '' }}"
                        />
                    </div>
                </div>
                <div class="grid grid-cols-2 lg:gap-4 mb-4 lg:mb-0">
                    <div class="form-row col-span-2 lg:col-span-1">
                        <label for="reg_billing_first_name">
                            <?php echo __('First name', 'woocommerce'); ?>
                        </label>
                        <input
                            type="text"
                            class="input-text"
                            name="billing_first_name"
                            id="reg_billing_first_name"
                            required
                            value="{{ !empty($_POST['billing_first_name']) ? $_POST['billing_first_name'] : '' }}"
                        />
                    </div>
                    <div class="form-row col-span-2 lg:col-span-1">
                        <label for="reg_billing_last_name">
                            <?php echo __('Last name', 'woocommerce'); ?>
                        </label>
                        <input
                            type="text"
                            class="input-text"
                            name="billing_last_name"
                            id="reg_billing_last_name"
                            required
                            value="{{ !empty($_POST['billing_last_name']) ? $_POST['billing_last_name'] : '' }}"
                        />
                    </div>
                </div>
                <div class="form-row">
                    <label for="reg_billing_phone">
                        <?php echo __('Phone', 'woocommerce'); ?>
                    </label>
                    <input
                        type="text"
                        class="input-text"
                        name="billing_phone"
                        id="reg_billing_phone"
                        required
                        value="{{ !empty($_POST['billing_phone']) ? $_POST['billing_phone'] : '' }}"
                    />
                </div>
                <div class="clear"></div>
                <div class="form-row">
                    <label for="reg_email">
                        <?php echo __('Email address', 'woocommerce'); ?>
                    </label>
                    <input
                        type="email"
                        class="input-text"
                        name="email"
                        id="reg_email"
                        autocomplete="email"
                        value="{{ !empty($_POST['email']) ? wp_unslash($_POST['email']) : ''}}"
                    />
                </div>

                @if (get_option('woocommerce_registration_generate_password') === 'no')
                    <div class="form-row">
                        <label for="reg_password">
                            <?php echo __('Password', 'woocommerce'); ?>
                        </label>
                        <input
                            type="password"
                            class="input-text"
                            name="password"
                            id="reg_password"
                            autocomplete="new-password"
                        />
                    </div>
                @else
                   <p class="mb-4">
                        <?php echo __('A link to set a new password will be sent to your email address.', 'woocommerce'); ?>
                    </p>
                @endif

                <div class="form-row">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            required
                            class="mr-2"
                            name="accept_terms_conditions"
                            id="accept_terms_conditions"
                        />
                        <?php echo sprintf(__('I accept the <a href="%s" class="underline">terms and conditions</a>', 'woocommerce'), get_fields('options')['terms_and_conditions_link'] ?? ''); ?>
                    </label>
                </div>


                @php do_action('woocommerce_register_form'); @endphp

                <div class="woocommerce-form-row form-row">
                    @php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); @endphp
                    <button
                        type="submit"
                        class="button-outline button-outline-heavy-metal mt-8"
                        name="register"
                    >
                        <?php echo __('Register', 'woocommerce'); ?>
                    </button>
                </div>
                @php do_action('woocommerce_register_form_end'); @endphp
            </form>
        </div>
    @endif
</div>
