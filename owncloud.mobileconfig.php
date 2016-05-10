<?php
header('Content-Type: application/x-apple-aspen-config');
header('Content-Disposition: attachment; filename="mail.mobileconfig"');
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
                <string><?php echo $_GET['email'];?></string>
                <key>IncomingMailServerUsername</key>
                <string><?php echo $_GET['email'];?></string>
                <key>OutgoingMailServerUsername</key>
                <string><?php echo $_GET['email'];?></string>
                <key>EmailAccountDescription</key>
                <string>PRIMARY_HOSTNAME mail</string>
                <key>EmailAccountType</key>
                <string>EmailTypeIMAP</string>
                <key>IncomingMailServerAuthentication</key>
                <string>EmailAuthPassword</string>
                <key>IncomingMailServerHostName</key>
                <string>PRIMARY_HOSTNAME</string>
                <key>IncomingMailServerPortNumber</key>
                <integer>993</integer>
                <key>IncomingMailServerUseSSL</key>
                <true/>
                <key>OutgoingMailServerAuthentication</key>
                <string>EmailAuthPassword</string>
                <key>OutgoingMailServerHostName</key>
                <string>PRIMARY_HOSTNAME</string>
                <key>OutgoingMailServerPortNumber</key>
                <integer>587</integer>
                <key>OutgoingMailServerUseSSL</key>
                <true/>
                <key>OutgoingPasswordSameAsIncomingPassword</key>
                <true/>
                <key>PayloadDescription</key>
                <string>PRIMARY_HOSTNAME (Synergy Village)</string>
                <key>PayloadDisplayName</key>
                <string>PRIMARY_HOSTNAME mail</string>
                <key>PayloadIdentifier</key>
                <string>email.synergy.mobileconfig.PRIMARY_HOSTNAME.E-Mail</string>
                <key>PayloadOrganization</key>
                <string></string>
                <key>PayloadType</key>
                <string>com.apple.mail.managed</string>
                <key>PayloadUUID</key>
                <string>UUID2</string>
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
			    <string>ezra@synergy-village.org</string>
			    <key>CalDAVHostName</key>
			    <string>sogo.synergy-village.org</string>
			    <key>CalDAVPort</key>
			    <real>443</real>
			    <key>CalDAVPrincipalURL</key>
			    <string>/SOGo/dav/ezra/</string>
			    <key>CalDAVUseSSL</key>
			    <true/>
			    <key>CalDAVUsername</key>
			    <string>ezra</string>
			    <key>PayloadDescription</key>
			    <string>ezra@synergy-village.org calendar</string>
			    <key>PayloadDisplayName</key>
			    <string>ezra@synergy-village.org calendar</string>
			    <key>PayloadIdentifier</key>
			    <string>ch.netfuture.sogo.profile.caldav.org.synergy-village.ezra</string>
			    <key>PayloadOrganization</key>
			    <string>synergy-village.org</string>
			    <key>PayloadType</key>
			    <string>com.apple.caldav.account</string>
			    <key>PayloadUUID</key>
			    <string>8A8D7997-FBA0-4FDC-88E6-4643159E57D5</string>
			    <key>PayloadVersion</key>
			    <integer>1</integer>
		    </dict>
		    <dict>
			    <key>CardDAVAccountDescription</key>
			    <string>ezra@synergy-village.org</string>
			    <key>CardDAVHostName</key>
			    <string>sogo.synergy-village.org</string>
			    <key>CardDAVPort</key>
			    <integer>443</integer>
			    <key>CardDAVPrincipalURL</key>
			    <string>/SOGo/dav/ezra/</string>
			    <key>CardDAVUseSSL</key>
			    <true/>
			    <key>CardDAVUsername</key>
			    <string>ezra</string>
			    <key>PayloadDescription</key>
			    <string>ezra@synergy-village.org contacts</string>
			    <key>PayloadDisplayName</key>
			    <string>ezra@synergy-village.org contacts</string>
			    <key>PayloadIdentifier</key>
			    <string>ch.netfuture.sogo.profile.carddav.org.synergy-village.ezra</string>
			    <key>PayloadOrganization</key>
			    <string>synergy-village.org</string>
			    <key>PayloadType</key>
			    <string>com.apple.carddav.account</string>
			    <key>PayloadUUID</key>
			    <string>F42A5611-6F85-4CA4-9CDD-A89F5E6EE499</string>
			    <key>PayloadVersion</key>
			    <integer>1</integer>
		    </dict>
        </array>
        <key>PayloadDescription</key>
        <string>PRIMARY_HOSTNAME (Synergy Village)</string>
        <key>PayloadDisplayName</key>
        <string>PRIMARY_HOSTNAME</string>
        <key>PayloadIdentifier</key>
        <string>email.synergy.mobileconfig.PRIMARY_HOSTNAME</string>
        <key>PayloadOrganization</key>
        <string></string>
        <key>PayloadRemovalDisallowed</key>
        <false/>
        <key>PayloadType</key>
        <string>Configuration</string>
        <key>PayloadUUID</key>
        <string>UUID4</string>
        <key>PayloadVersion</key>
        <integer>1</integer>
    </dict>
</plist>
