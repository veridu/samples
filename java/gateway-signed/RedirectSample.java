import com.veridu.gateway.sdk.Redirect;
import java.io.UnsupportedEncodingException;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.jose4j.lang.JoseException;

public class RedirectSample {

    public static void main(String[] args) {
        try {
            Redirect redir = new Redirect(Settings.CLIENT, Settings.SECRET);
            // Unique username assigned by your system (this is an optional parameter for redir.generateUrl)
            // more info: https://veridu.com/wiki/User_ID
            String username = "unique-user-id";

            // generate redirect url with appended signature (username parameter is optional)
            System.out.println("URL: ".concat(redir.generateUrl(username)));
            // redirect token id for callback validation
            System.out.println("TID: ".concat(redir.getTokenId()));
        } catch (UnsupportedEncodingException | JoseException ex) {
            Logger.getLogger(RedirectSample.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

}
