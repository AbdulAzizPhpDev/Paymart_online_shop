{assign var="id" value=$id|default:"main_login"}

{script src="js/addons/authentication/func.js"}

{capture name="login"}
    <form
            name="{$id}_form"
            action="{"profiles.send_sms"|fn_url}"
            method="post"
            class="cm-ajax "
            id="auth-form"
    >
        {if $style == "popup"}
            <input type="hidden" name="result_ids" value="{$id}_login_popup_form_container" />
            <input type="hidden" name="login_block_id" value="{$id}" />
            <input type="hidden" name="quick_login" value="1" />
        {/if}

        <input type="hidden" name="return_url" value="{$smarty.request.return_url|default:$config.current_url}" />
        <input type="hidden" name="redirect_url" value="{$redirect_url|default:$config.current_url}" />

        <div v-if="isSMSSent" class="ty-control-group code">
            <label
                    for="buyer-phone-code"
                    class="ty-login__filed-label ty-control-group__label cm-required cm-trim "
            >
                Code
            </label>
            <input
                    v-model="buyerCode"
                    id="buyer-phone-code"
                    type="text"
                    name="phone-code"
                    placeholder="SMS Code"
                    maxlength="17"
                    class="ty-login__input"
            />
        </div>

        <div v-else class="ty-control-group phone">
            <label
                    for="buyer-phone"
                    class="ty-login__filed-label ty-control-group__label cm-required cm-trim "
            >
                {__("phone")}
            </label>
            <input
                    v-model="buyerPhone"
                    id="buyer-phone"
                    type="text"
                    name="phone"
                    placeholder="Phone Number"
                    maxlength="17"
                    class="ty-login__input"
            />
        </div>

        <button
                v-if="isSMSSent"
                type="button"
                class="ty-btn ty-btn__secondary"
                id="confirmCodeBtn"
                @click="confirmCode"
        >
            Confirm Code
        </button>
        <button
                v-else
                type="button"
                class="ty-btn ty-btn__secondary"
                id="sendSMSBtn"
                @click="sendSMS"
        >
            Send SMS
        </button>

        {if $style == "popup"}
            <div v-if="hasError" class="ty-login-form__wrong-credentials-container">
                <span
                        v-for="(err, index) in errors"
                        :key="index"
                        class="ty-login-form__wrong-credentials-text ty-error-text"
                >
                    %% err.text %%
                </span>
            </div>
            <div v-if="error !== null" class="ty-login-form__wrong-credentials-container">
                <span class="ty-login-form__wrong-credentials-text ty-error-text">
                    %% error %%
                </span>
            </div>
        {/if}

        {*{hook name="index:login_buttons"}
            <div class="buttons-container clearfix">
                <div class="ty-float-right">
                    <button class="cm-form-dialog-closer ty-btn ty-btn__secondary" type="submit">SEND SMS</button>
                </div>
            </div>
        {/hook}*}
    </form>
{/capture}

{if $style == "popup"}
    <div id="{$id}_login_popup_form_container">
        {$smarty.capture.login nofilter}
    </div>
{/if}

<script>
const modal = new Vue({
  delimiters: ['%%', '%%'],
  el: '.ty-login-popup',
  data: {
    isSMSSent: false,
    hasError: false,
    errors: null,
    error: null,
    buyerPhone: null,
    buyerCode: null,
  },
  methods: {
    sendSMS(event) {
      $.ceAjax('request', fn_url('profiles.send_sms'), {
        method: 'POST',
        data: {
          phone: modal.buyerPhone.replace('+', ''),
        },
        callback: function callback(response) {
          const { result } = response;
          if (result) {
            if (result.status === 'success') {
              modal.isSMSSent = true;
            } else {
              modal.hasError = true;
              if (typeof result.response.message !== 'string') {
                modal.errors = result.response.message;
              } else {
                modal.error = result.response.message;
              }
            }
          } else {
            console.error('Result does not exist. %cmethod[fn_url=profiles.send_sms]', 'color: white; padding: 2px 5px; border: 1px dashed green');
          }
        }
      });
    },
    confirmCode: function (event) {
      $.ceAjax('request', fn_url('profiles.confirm'), {
        method: 'POST',
        data: {
          phone: modal.buyerPhone.replace('+', ''),
          code: modal.buyerCode,
          redirect_url: $('input[name="redirect_url"]').val(),
        },
        callback: function callback(response) {
          console.log(response);
          // window.location.reload();
          /*const { result } = response;

          if (response) {
            if (result.status === 'success') {
              console.log('success');
            } else {
              methods.showErrors(result.response.message);
            }
          } else {
            console.error('response does not exist!');
          }*/
        },
      });
    },
  },
});
</script>
