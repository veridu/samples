import com.veridu.gateway.sdk.Redirect;
import java.io.UnsupportedEncodingException;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.jose4j.lang.JoseException;

public class RedirectSample {

    public static void main(String[] args) {
        try {
            Redirect redir = new Redirect(Settings.CLIENT, Settings.SECRET);
            System.out.println("URL: ".concat(redir.generateUrl("some-unique-user-id")));
            System.out.println("TID: ".concat(redir.getTokenId()));
        } catch (UnsupportedEncodingException | JoseException ex) {
            Logger.getLogger(RedirectSample.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

}
