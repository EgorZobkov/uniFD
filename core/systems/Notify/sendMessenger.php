public function sendMessenger($messenger=""){
    global $app;

    $text = "";
    $keyboard = [];
    $user = [];
    $whomUser = [];
    $result = [];

    $macrosList = $this->macrosBuild();

    if($this->code){

        if($this->code == "system_new_users"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_84438949b14f6252243fe32b0ccfad9f")."\n";
            $text .= translate("tr_d38d6d925c80a2267031f3f03d0a9070")." - {user_name}\n";
            $text .= translate("tr_7a176a6a64c888d6496097dc0440cbc3")." - {user_email}\n";
            $text .= translate("tr_2928e19c705428df3c9f1e6d4ea8042f")." - {user_phone}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>getUrlDashboard().'/user/card/'.$this->params["user_id"], 'text'=>translate("tr_099eb541519b8a89eea93fae6c83fb07")]
                    ]
                ]
            ];

        }elseif($this->code == "system_new_transaction"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_acc4aaa58138e86ce4e9d4beb2ed23c2")." {amount}\n";
            $text .= translate("tr_dfde1ffd136702faa5d88f9317918b49") . " - {transaction_name}\n";
            $text .= translate("tr_91a72f953017cf1888e332146adacd83") . " - {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>getUrlDashboard().'/user/card/'.$this->params["user_id"], 'text'=>translate("tr_099eb541519b8a89eea93fae6c83fb07")]
                    ]
                ]
            ];

        }elseif($this->code == "system_chat_new_message"){

            $text = "<b>{project_name}</b>\n";
            $text .= "✉{message_text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-chat", [], true), 'text'=>translate("tr_1299ff65057c53c4512f4e3958f28216")]
                    ]
                ]
            ];

        }elseif($this->code == "system_open_dispute_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_3f870f5c746cd3ea3c547981119023e4") . " №{order_id}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-deal-card", [$this->params["order_id"]], true), 'text'=>translate("tr_55ae6e6aa3ddc52d8f369deebd2afab9")]
                    ]
                ]
            ];

        }elseif($this->code == "system_new_user_verification"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_2d878a54f60ccca3b5b25d03d96379b8") . " {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-users-verifications", [], true), 'text'=>translate("tr_76ccf661fc25a07cc57c9f538c9bc244")]
                    ]
                ]
            ];

        }elseif($this->code == "system_open_shop"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_7e79418fc78b28008077711cb9f90fb0")."\n";
            $text .= translate("tr_602680ed8916dcc039882172ef089256") . " - {shop_name}\n";
            $text .= translate("tr_f154d6cc8945d799f4b31ccc1e0019f5") . " - {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-shops", [], true), 'text'=>translate("tr_4c8c33a521ae06f772b6efbd20ffefca")]
                    ]
                ]
            ];

        }elseif($this->code == "system_edit_shop"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_f579c45ab1bee9ea3cfb3028a5dbe591") . " <b>{shop_name}</b> " . translate("tr_0e28049785706e06eb4f57148f2aed4a")."\n";

            if($this->params["action"] == "edit_shop"){
                $text .= translate("tr_191e2d9893e5052b6300a5a55464ca1a")."\n";
            }elseif($this->params["action"] == "add_banner_shop"){
                $text .= translate("tr_ad3f358060a03f1105b59bb99e59c440")."\n";
            }elseif($this->params["action"] == "add_page_shop"){
                $text .= translate("tr_d0d2e07126398bddc73ae345db128600")."\n";
            }elseif($this->params["action"] == "edit_page_text_shop"){
                $text .= translate("tr_b834b3cd193b4e7ded55ca4b33ab3bc9") . " <b>{page_name}</b>\n";
            }
            $text .= translate("tr_f154d6cc8945d799f4b31ccc1e0019f5") . " - {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-shops", [], true), 'text'=>translate("tr_4c8c33a521ae06f772b6efbd20ffefca")]
                    ]
                ]
            ];

        }elseif($this->code == "system_add_stories"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_76215bba4518064d5af4218ff6a82f73") . " {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-stories", [], true), 'text'=>translate("tr_db4409f9f1ea52fac92952bb9f5fea57")]
                    ]
                ]
            ];

        }elseif($this->code == "system_create_ad"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_0c65560f21894bd6f44cbf26f0b2ecde")."\n";
            $text .= translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0")." - {ad_title}\n";
            $text .= translate("tr_c95a1e2de00ee86634e177aecca00aed")." - {ad_category_name}\n";
            $text .= translate("tr_f154d6cc8945d799f4b31ccc1e0019f5")." - {user_name}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-ads", [], true), 'text'=>translate("tr_e32e402c63dd8a64bfa10a4c33a648ca")]
                    ]
                ]
            ];

        }elseif($this->code == "system_create_review"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_d803086c7492d6b9c43197040cc38771")."\n";
            $text .= translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d") . " - {ad_title}\n";
            $text .= translate("tr_7c7d054bc5ae9c0d93b69431dfdf2264") . " - {user_name}\n";
            $text .= translate("tr_4a3f5e52678242b15f4e65f85ff3345c") . " - {review_text}\n";
            $text .= translate("tr_304ce2c8c71568195da204b85122598a") . " - {review_rating}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-reviews", [], true), 'text'=>translate("tr_2b70c86c4ee7fafdc5b45f79b60b3d10")]
                    ]
                ]
            ];

        }elseif($this->code == "system_add_complaint_user"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_e97ddccb36e7f80c57288a2ea789388d")."\n";
            $text .= translate("tr_7c7d054bc5ae9c0d93b69431dfdf2264") . " - {from_user_name}\n";
            $text .= translate("tr_f154d6cc8945d799f4b31ccc1e0019f5") . " - {whom_user_name}\n";
            $text .= translate("tr_8c45d9cf5766a98100df8108d3235247") . " - {complaint_text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-complaints", [], true), 'text'=>translate("tr_81646f695bc69ab8517b793eb05ecc13")]
                    ]
                ]
            ];

        }elseif($this->code == "system_add_complaint_ad"){

            $text = "<b>{project_name}</b>\n";
            $text .= translate("tr_fa6770e16b2917a48e6a081a919c79be")."\n";
            $text .= translate("tr_7c7d054bc5ae9c0d93b69431dfdf2264") . " - {from_user_name}\n";
            $text .= translate("tr_f154d6cc8945d799f4b31ccc1e0019f5") . " - {whom_user_name}\n";
            $text .= translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d") . " - {ad_title}\n";
            $text .= translate("tr_8c45d9cf5766a98100df8108d3235247") . " - {complaint_text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("dashboard-complaints", [], true), 'text'=>translate("tr_81646f695bc69ab8517b793eb05ecc13")]
                    ]
                ]
            ];

        }elseif($this->code == "board_ad_active"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, " . translate("tr_8f837444c41f4c1de63df8f3ac6756bd") . " <b>{ad_title}</b> " . translate("tr_6b9fed28392ed2159a2e3bbd3af3f747") . "\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["ad_link"], 'text'=>translate("tr_4d6400738b124c2747d12988e45a84e8")]
                    ]
                ]
            ];

        }elseif($this->code == "board_ad_blocked"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_8f837444c41f4c1de63df8f3ac6756bd") . " <b>{ad_title}</b> ".translate("tr_2be70b953003d1fa7c2250d8a1aeb80f") . "\n";
            $text .= translate("tr_34fd5ae7f6d60c61d3a169a4d9457730") . "\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["ad_link"], 'text'=>translate("tr_4d6400738b124c2747d12988e45a84e8")]
                    ]
                ]
            ];

        }elseif($this->code == "user_balance_replenishment"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_7615dc29e27b7588a97802be4bd41f4d")." <b>{amount}</b>\n";

            if($this->params["text"]){
                $text .= translate("tr_686eb72bc896f521125728b32bb38d51")." - {text}\n";
            }

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "user_balance_write_downs"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_9a6796bdaca277c9418f7c63b271c6c0")." <b>{amount}</b>\n";

            if($this->params["text"]){
                $text .= translate("tr_686eb72bc896f521125728b32bb38d51")." - {text}\n";
            }

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "chat_new_message"){

            $text = "<b>{project_name}</b>\n";
            $text .= "✉{message_text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->router->getRoute("profile-chat", [], true), 'text'=>translate("tr_1299ff65057c53c4512f4e3958f28216")]
                    ]
                ]
            ];

        }elseif($this->code == "deal_error"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_162debde81deaa702871afde48f7a20b")." №{order_id}\n";
            $text .= translate("tr_942d485111449e46351e5473c0954f2f")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "payment_order_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_4c717d7d48cc9e90c80dc3d12da13dec")." №{order_id} ".translate("tr_01340e1c32e59182483cfaae52f5206f")." {amount}\n";
            $text .= translate("tr_91a72f953017cf1888e332146adacd83")." - {from_user_name}\n";
            $text .= translate("tr_dfde1ffd136702faa5d88f9317918b49")." - {ad_title}\n";
            $text .= translate("tr_cb8bfd4d5a1df2e7459f2fe740c8dcba")." - {count}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "create_order_booking"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_e7d50c90e6acb758da5b7bf59b97aa29")." <b>{ad_title}</b>\n";
            $text .= translate("tr_64cdb8db21af169518cc6d997fb81086")."\n";
            $text .= translate("tr_4af22f2d58c928ab7557d204d2459eb6")." - {from_user_name}\n";
            $text .= translate("tr_b36933fc385983497bde945fb80b33ab")." - {contact_user_name}, {contact_user_phone}, {contact_user_email}\n";
            $text .= translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d")." - {ad_title}\n";
            $text .= translate("tr_cf59ebf9edf7ebe3ece76645abb6de12")." - {amount}\n";
            $text .= translate("tr_2f2763f1cb99164e85834505b62073b4")." - {date_start} - {date_end}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "confirmed_order_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_c6ff3b2901b7ad603f6194c379ba36ea")." №{order_id} ".translate("tr_ea3084ce9163cd1760abfde3299448df")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "change_status_order_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_0c0e6862441b4b3171efd93e8bad3e6b")." №{order_id}\n";
            $text .= translate("tr_942d485111449e46351e5473c0954f2f")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "open_dispute_order_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_f58a6ebf6da1e8327cfe28485303672e")." №{order_id}\n";
            $text .= translate("tr_942d485111449e46351e5473c0954f2f")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "cancel_order_deal"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_9d7ec5f642a6e239d290cfa6472da300")." №{order_id} ".translate("tr_71dd64eab0b03532e8de9d7b301ecf9f")."\n";
            $text .= translate("tr_942d485111449e46351e5473c0954f2f")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["link"], 'text'=>translate("tr_be3e344a5fa1896aa5d388b392733ed3")]
                    ]
                ]
            ];

        }elseif($this->code == "board_ad_end_term"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_241473bf17f1e2f6de8f9d30c64d07b6")." <b>{ad_title}</b> ".translate("tr_b436e6bef8319354dc254aedfd9f800a")."\n";
            $text .= translate("tr_c81290eac4d93d8fd2c5a7d6df785ee6")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["ad_link"], 'text'=>translate("tr_fafc7b5705bdb2dfa438a7b671dfb3a0")]
                    ]
                ]
            ];

        }elseif($this->code == "service_tariff_end_term"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_bd0b7b3c2d89b87127345a0ffcf81dbb")."\n";
            $text .= translate("tr_55a5e47bfd8a64bf7236c86f650c84cc")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "soon_service_tariff_end_term"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_b00f1f02f709c2f60dbf70203834e1c8")."\n";
            $text .= translate("tr_7e4aafa0dfcdce51bb3f81c0d7dfe71a")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "referral_accrued_award"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_90572379599960fa66c82c50aa518b57")." {amount} ".translate("tr_6c992b9574206303414ac2f55e2d4076")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "user_verification_verified"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_66e318c5b65e5331afd8e99baef1295d")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "user_verification_rejected"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_f60af68724eaba8ff066e514f827eb22")."\n";
            $text .= translate("tr_686eb72bc896f521125728b32bb38d51")." - {text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$app->component->profile->linkUserCard($this->user->alias), 'text'=>translate("tr_b24a9e7015b6293be4333d5520e0da53")]
                    ]
                ]
            ];

        }elseif($this->code == "user_shop_published"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_0b0b1a8dcca2868225a61ecc9cc33224")." <b>{shop_name}</b> ".translate("tr_c614f0409f21d4cb4bedfea31b11260c")."\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["shop_link"], 'text'=>translate("tr_35cdd14da9661e80ab00d05c44335c2d")]
                    ]
                ]
            ];

        }elseif($this->code == "user_shop_rejected"){

            $text = "<b>{project_name}</b>\n";
            $text .= "{user_name}, ".translate("tr_e130ea3d7b0fc42b53639ee0598207cb")." <b>{shop_name}</b> ".translate("tr_c94e6d358ab8da0118d2353a7e4fd982")."\n";
            $text .= translate("tr_686eb72bc896f521125728b32bb38d51")." - {text}\n";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['url'=>$this->params["shop_link"], 'text'=>translate("tr_35cdd14da9661e80ab00d05c44335c2d")]
                    ]
                ]
            ];

        }


    }else{

        $text = $this->params["text"];

    }

    if($macrosList){
        foreach ($macrosList as $key => $value) {
            $text = str_replace($key, $value, $text);
        }
    }

    $result = $app->addons->messenger($messenger)->sendMessage(["chat_id"=>$this->params["chat_id"], "text"=>$text, "keyboard"=>$keyboard]);

    $this->params(null);
    $this->code(null);
    $this->userId(null);
    $this->to(null);

    return $result;

}