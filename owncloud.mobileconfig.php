<?php
header('Content-Type: application/x-apple-aspen-config');
header('Content-Disposition: attachment; filename="owncloud.mobileconfig"');

function domain() {
    $parts = explode('@', $_GET['email']);
    return $parts[1];
}

function user() {
    $parts = explode('@', $_GET['email']);
    return $parts[0];
}

function identifier() {
    $parts = explode('.', domain());
    return $parts[1] . '.' . $parts[0] . '.' . user();
}

?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<!--
     iOS/OS X Configuration Profile

     Mobileconfig for iOS/OS X users to setup IMAP, SMTP, Contacts & Calendar

     https://developer.apple.com/library/ios/featuredarticles/iPhoneConfigurationProfileRef/Introduction/Introduction.html
   -->
<plist version="1.0">
    <dict>
        <key>PayloadContent</key>
        <array>
            <dict>
                <key>EmailAddress</key>
                <string><?= $_GET['email']; ?></string>
                <key>IncomingMailServerUsername</key>
                <string><?= $_GET['email']; ?></string>
                <key>OutgoingMailServerUsername</key>
                <string><?= $_GET['email']; ?></string>
                <key>EmailAccountDescription</key>
                <string><?= $_GET['email']; ?></string>
                <key>EmailAccountType</key>
                <string>EmailTypeIMAP</string>
                <key>IncomingMailServerAuthentication</key>
                <string>EmailAuthPassword</string>
                <key>IncomingMailServerHostName</key>
                <string>mail.<?= domain(); ?></string>
                <key>IncomingMailServerPortNumber</key>
                <integer>993</integer>
                <key>IncomingMailServerUseSSL</key>
                <true/>
                <key>OutgoingMailServerAuthentication</key>
                <string>EmailAuthPassword</string>
                <key>OutgoingMailServerHostName</key>
                <string>mail.<?= domain(); ?></string>
                <key>OutgoingMailServerPortNumber</key>
                <integer>587</integer>
                <key>OutgoingMailServerUseSSL</key>
                <true/>
                <key>OutgoingPasswordSameAsIncomingPassword</key>
                <true/>
                <key>PayloadDescription</key>
                <string><?= $_GET['email']; ?></string>
                <key>PayloadDisplayName</key>
                <string><?= $_GET['email']; ?></string>
                <key>PayloadIdentifier</key>
                <string><?= identifier(); ?>.email</string>
                <key>PayloadOrganization</key>
                <string><?= $_GET['doamin']; ?></string>
                <key>PayloadType</key>
                <string>com.apple.mail.managed</string>
                <key>PayloadUUID</key>
                <string><?= uniqid(); ?></string>
                <key>PayloadVersion</key>
                <integer>1</integer>
                <key>PreventAppSheet</key>
                <false/>
                <key>PreventMove</key>
                <false/>
                <key>SMIMEEnabled</key>
                <false/>
            </dict>
            <dict>
                <key>CalDAVAccountDescription</key>
                <string><?= $_GET['email']; ?></string>
                <key>CalDAVHostName</key>
                <string>cloud.<?= domain(); ?></string>
                <key>CalDAVPort</key>
                <real>443</real>
                <key>CalDAVPrincipalURL</key>
                <string>/remote.php/dav/calendars/<?= $_GET['email']; ?>/default/</string>
                <key>CalDAVUseSSL</key>
                <true/>
                <key>CalDAVUsername</key>
                <string><?= $_GET['email']; ?></string>
                <key>PayloadDescription</key>
                <string><?= $_GET['email']; ?> calendar</string>
                <key>PayloadDisplayName</key>
                <string><?= $_GET['email']; ?> calendar</string>
                <key>PayloadIdentifier</key>
                <string><?= identifier(); ?>.calendar</string>
                <key>PayloadOrganization</key>
                <string><?= domain(); ?></string>
                <key>PayloadType</key>
                <string>com.apple.caldav.account</string>
                <key>PayloadUUID</key>
                <string><?= uniqid(); ?></string>
                <key>PayloadVersion</key>
                <integer>1</integer>
            </dict>
            <dict>
                <key>CardDAVAccountDescription</key>
                <string><?= $_GET['email']; ?></string>
                <key>CardDAVHostName</key>
                <string>cloud.<?= domain(); ?></string>
                <key>CardDAVPort</key>
                <integer>443</integer>
                <key>CardDAVPrincipalURL</key>
                <string>/remote.php/dav/addressbooks/users/<?= $_GET['email']; ?>/default/</string>
                <key>CardDAVUseSSL</key>
                <true/>
                <key>CardDAVUsername</key>
                <string><?= $_GET['email']; ?></string>
                <key>PayloadDescription</key>
                <string><?= $_GET['email']; ?> contacts</string>
                <key>PayloadDisplayName</key>
                <string><?= $_GET['email']; ?> contacts</string>
                <key>PayloadIdentifier</key>
                <string><?= identifier(); ?>.contacts</string>
                <key>PayloadOrganization</key>
                <string><?= domain(); ?></string>
                <key>PayloadType</key>
                <string>com.apple.carddav.account</string>
                <key>PayloadUUID</key>
                <string><?= uniqid(); ?></string>
                <key>PayloadVersion</key>
                <integer>1</integer>
            </dict>
        </array>
        <key>PayloadDescription</key>
        <string><?= $_GET['email']; ?> cloud</string>
        <key>PayloadDisplayName</key>
        <string><?= $_GET['email']; ?> cloud</string>
        <key>PayloadIdentifier</key>
        <string><?= identifier(); ?>.owncloud</string>
        <key>PayloadOrganization</key>
        <string></string>
        <key>PayloadRemovalDisallowed</key>
        <false/>
        <key>PayloadType</key>
        <string>Configuration</string>
        <key>PayloadUUID</key>
        <string><?= uniqid(); ?></string>
        <key>PayloadVersion</key>
        <integer>1</integer>
    </dict>
</plist>
