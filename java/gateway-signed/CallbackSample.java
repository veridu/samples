import com.veridu.gateway.exception.TokenVerificationFailed;
import com.veridu.gateway.sdk.Callback;
import java.io.UnsupportedEncodingException;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.jose4j.jwt.MalformedClaimException;
import org.jose4j.jwt.consumer.InvalidJwtException;

public class CallbackSample {

    public static void main(String[] args) {
        try {
            Callback cb = new Callback(Settings.CLIENT, Settings.SECRET);
            // extracted from query parameter
            String token = "";
            // kept from redirection token
            String tokenId = "";

            cb.checkCallbackSignature(token, tokenId);
            System.out.println("Username: ".concat(cb.getUsername()));
            if (cb.getPass()) {
                System.out.println("Pass: TRUE");
            } else {
                System.out.println("Pass: FALSE");
            }
        } catch (UnsupportedEncodingException | InvalidJwtException | MalformedClaimException | TokenVerificationFailed ex) {
            Logger.getLogger(CallbackSample.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

}
