<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    </head>
    
    <body style="font-family: 'Open Sans', sans-serif;">
        <div style="width: 100%; background-color: #F7F7F7; padding-top: 120px; padding-bottom: 120px;">

            <div style="text-align: center;">
                <img src="{{ $message->embed( public_path() . '/images/core/email-logo-vertical.png' ) }}" style="margin-left: auto; margin-right: auto; margin-bottom: 60px; width: 100px; height: auto;">
            </div>

            <div style="width: 80%; background-color: white; border: 2px solid #DD1A22; border-top-width: 10px; margin-left: auto; margin-right: auto; padding: 6px;">

                <div style="margin-top: 10px;">
                    <label style="font-weight: bold;">@lang('shared.MAIL_OPENING')<br><br></label>
                    {!! $text !!}
                </div>

                <div>
                    <br>
                    <br>
                    @lang('shared.MAIL_SIGNATURE')
                </div>
                <div>
                    <img src="{{ $message->embed( public_path() . '/images/core/email-logo-horizontal.png' ) }}" style="width: auto; height: 18px; margin-top: 4px;">
                </div>
                <div style="height: 10px;"></div>
            </div>
        </div>
    </body>
</html>