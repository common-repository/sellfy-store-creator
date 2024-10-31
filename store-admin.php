<div class="wrap">
    <h2>
        Create your
        <a class="sellfy-logo" href="https://sellfy.com/" target="_blank">
            <img src="<?php echo plugins_url( 'sellfy-store-creator/images/sellfy-profile-logo.png')?>" />
        </a>
        store page
    </h2>
    <div class="updated settings-error created" id="sellfy_store_error_message">
        <p class="success-text">
            <strong>Your Sellfy store page is
            <span class="store-create">created</span>
            <span class="store-update">updated</span>
            successfully. <a href="#" target="_blank">View store page</a></strong>
        </p>
        <p class="error-text"></p>
    </div>
    <div class="sellfy-one-step">
    <h3>1. Account info:</h3>
        <a class="button-primary" href="#">Create Sellfy.com account</a>
        <a class="button-secondary" href="#">I already have a Sellfy.com account</a>
    </div>
    <div class="sellfy-one-step">
        <h3>2. Create store page</h3>
        <form method="post" action="" id="sellfy_create_page">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="sellfy_username">Your Sellfy username</label>
                </th>
                <td>
                    <input class="regular-text" type="text" name="sellfy_username" value="<?php echo $sellfy_settings->sellfy_username;?>">
                    <p class="description">You can find your Sellfy username in <a href="#">"Account settings"</a></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="sellfy_store_title">Store title</label>
                </th>
                <td>
                    <input class="regular-text" type="text" name="sellfy_store_title" value="<?php echo $sellfy_settings->title;?>"/>
                    <p class="description">Wordpress page title (e.g. My store, Best ebooks, etc..)</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="sellfy_store_slug">Store slug</label>
                </th>
                <td>
                    <input class="regular-text" type="text" name="sellfy_store_slug" value="<?php echo $sellfy_settings->slug;?>"/>
                    <p class="description">Wordpress page slug (e.g. store, products, marketplace, etc..)</p>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="hidden" name="action" value="sellfy_create_store" />
            <input type="hidden" name="security" id="sellfy_security" value="<?php echo wp_create_nonce( "sellfy-store-create" );?>" />
        </p>
         <p class="<?php echo ($sellfy_settings->get_page() ? 'update' : 'create'); ?>-page" id="submit_holder">
            <input class="button button-primary create-button" type="submit" value="Create page" name="submit" />
            <input class="button button-primary update-button" type="submit" value="Update page" name="submit" />
            <input class="button button-secondaty update-button" type="button" value="Delete page" id="sellfy_delete_page" name="submit" />
        </p>
        </form>
    </div>
</div>

