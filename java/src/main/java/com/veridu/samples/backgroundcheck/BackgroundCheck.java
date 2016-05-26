package com.veridu.samples.backgroundcheck;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.util.HashMap;

import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import com.veridu.API;
import com.veridu.endpoint.Check;
import com.veridu.exceptions.SDKException;

public class BackgroundCheck {

    public static void main(String[] args) throws NumberFormatException, InterruptedException {
        try {
            // Get environment configs
            BackgroundCheck bc = new BackgroundCheck();
            JSONObject config = bc.readDefaultConfigFile();
            String key = config.get("KEY").toString();
            String secret = config.get("SECRET").toString();
            String version = config.get("VERSION").toString();
            String username = config.get("USERNAME").toString();

            // Instantiates the api
            API api = API.factory(key, secret, version);

            // Response JSON object
            JSONObject json;

            // creates new a read/write Veridu session
            // more info: https://veridu.com/wiki/Session_Resource
            api.getSession().create(false);

            // assigns the fresh Veridu session to user
            // more info: https://veridu.com/wiki/User_Resource
            api.getUser().create(username);
            // mimics form data
            HashMap<String, String> data = new HashMap<>();
            data.put("firstname", "");
            data.put("lastname", "");
            data.put("birthyear", "");
            data.put("bithmonth", "");
            data.put("birthday", "");
            data.put("address1", "");
            data.put("postcode", "");

            // You also may call retrieve without passing username as argument
            // because its already stored
            // sends the form data
            // more info: https://veridu.com/wiki/Personal_Resource
            json = api.getPersonal().retrieve();
            if (json.containsKey("state"))
                if (json.get("state") == "false")
                    api.getPersonal().update(data);
                else
                    api.getPersonal().create(data);

            /*
             * Creating background Check : Returns task_id as response First
             * parameter: provider (available: tracesmart) Second parameter:
             * SETUP (Dob, passport, etc.), to concatenate setups, just use the
             * | To see a list of setup, please visit:
             * https://veridu.com/wiki/TraceSmart
             */
            String task_id = api.getCheck().create("tracesmart", Check.TRACESMART_ADDRESS, username);
            // Prints task_id
            System.out.println(task_id);
            /*
             * Polling API to wait until check is done Note: can be done via
             * WebHook without polling
             */

            do {
                Thread.sleep(5000);
                json = api.getTask().details(Integer.parseInt(task_id));
            } while (Boolean.parseBoolean(json.get("running").toString()) == true);

            /*
             * Retrieves background check result more info:
             * https://veridu.com/wiki/Check_Resource
             */
            json = api.getCheck().listAll();
            /*
             * prints API response more details:
             * https://veridu.com/wiki/Check_Resource#
             * How_to_retrieve_data_from_one_provider
             */
            System.out.println(json);

        } catch (SDKException e) {
            e.printStackTrace();
        } catch (UnsupportedEncodingException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        } catch (ParseException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
    }

    private JSONObject readDefaultConfigFile() throws ParseException {
        InputStream is = this.getClass().getResourceAsStream("/config.json");
        BufferedReader bf = new BufferedReader(new InputStreamReader(is));
        StringBuilder configString = new StringBuilder();
        String line;
        try {
            line = bf.readLine();
            while (line != null) {
                configString.append(line);
                line = bf.readLine();
            }
            bf.close();
        } catch (IOException e) {
            e.printStackTrace();
        }

        JSONParser parser = new JSONParser();
        JSONObject json = (JSONObject) parser.parse(configString.toString());

        return json;
    }

}
