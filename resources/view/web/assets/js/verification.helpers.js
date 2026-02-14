/**
 * Verification Helpers Module
 * Common functions for email and phone verification
 */
export default class VerificationHelpers {
    constructor(helpers) {
        this.helpers = helpers;
        this.checkVerifyPhoneIntervalId = null;
    }

    /**
     * Check phone verification status periodically
     * @param {string} phone - Phone number to check
     */
    checkVerifyPhone(phone) {
        if (this.checkVerifyPhoneIntervalId) {
            clearInterval(this.checkVerifyPhoneIntervalId);
        }

        this.checkVerifyPhoneIntervalId = setInterval(() => {
            this.helpers.request({
                url: "check-verify-phone",
                data: { phone: phone }
            }, (data) => {
                if (data["status"] == true) {
                    this.helpers.hideModal("verificationCodeModal");
                    $(".actionSendVerifyCodeEmailContainer").hide();
                    $(".actionSendVerifyCodePhoneContainer").hide();
                    clearInterval(this.checkVerifyPhoneIntervalId);
                    this.checkVerifyPhoneIntervalId = null;
                }
            });
        }, 3000);
    }

    /**
     * Send verification code to email
     * @param {string} emailSelector - jQuery selector for email input
     * @param {HTMLElement} triggerElement - Element that triggered the action
     */
    sendVerifyCodeEmail(emailSelector, triggerElement) {
        const email = $(emailSelector).val();
        
        $('.form-label-error').hide();
        this.helpers.startProcessLoadButton($('.actionSendVerifyCodeEmail'));

        this.helpers.request({
            url: "send-code-verify-contact",
            data: { email: email }
        }, (data) => {
            if (data["status"]) {
                this.helpers.loadModal("verificationCode", { email: email }, null, triggerElement);
            } else {
                if (data["captcha"]) {
                    this.helpers.openCaptcha(data["captcha_id"], triggerElement);
                } else if (data["answer"]) {
                    this.helpers.showNoticeAnswer(data["answer"]);
                }
            }
            this.helpers.endProcessLoadButton($('.actionSendVerifyCodeEmail'));
        });
    }

    /**
     * Send verification code to phone
     * @param {string} phoneSelector - jQuery selector for phone input
     * @param {HTMLElement} triggerElement - Element that triggered the action
     */
    sendVerifyCodePhone(phoneSelector, triggerElement) {
        const phone = $(phoneSelector).val();
        let call_phone = null;

        $('.form-label-error').hide();
        this.helpers.startProcessLoadButton($('.actionSendVerifyCodePhone'));

        this.helpers.request({
            url: "send-code-verify-contact",
            data: { phone: phone }
        }, (data) => {
            if (data["status"]) {
                call_phone = data["call_phone"];
                
                this.helpers.loadModal("verificationCode", { phone: phone }, () => {
                    if (call_phone) {
                        $(".verify-call-phone-container").html(call_phone);
                        this.checkVerifyPhone(phone);
                    }
                }, triggerElement);
            } else {
                if (data["captcha"]) {
                    this.helpers.openCaptcha(data["captcha_id"], triggerElement);
                } else if (data["answer"]) {
                    this.helpers.showNoticeAnswer(data["answer"]);
                }
            }
            this.helpers.endProcessLoadButton($('.actionSendVerifyCodePhone'));
        });
    }

    /**
     * Check if contact needs verification
     * @param {string} contactType - 'email' or 'phone'
     * @param {string} contactValue - Contact value to check
     * @param {string} containerSelector - jQuery selector for container to show/hide
     */
    checkVerifyContact(contactType, contactValue, containerSelector) {
        const data = {};
        data[contactType] = contactValue;

        this.helpers.request({
            url: "check-verify-contact",
            data: data
        }, (response) => {
            if (response["status"]) {
                $(containerSelector).show();
            } else {
                $(containerSelector).hide();
            }
        });
    }

    /**
     * Clean up intervals on destroy
     */
    destroy() {
        if (this.checkVerifyPhoneIntervalId) {
            clearInterval(this.checkVerifyPhoneIntervalId);
            this.checkVerifyPhoneIntervalId = null;
        }
    }
}
