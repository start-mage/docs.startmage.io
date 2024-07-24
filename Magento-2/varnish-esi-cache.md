# Troubleshooting Magento ESI Varnish Cache Issues

If you encounter issues with the Magento ESI Varnish Cache not working properly, follow these steps to troubleshoot and resolve the problem:

## Identifying the Issue

When utilizing the ESI Cache in Magento, Varnish should render the Magento ESI blocks. One common issue is the absence of the top navigation due a wrong varnish configuration for the ESI block cache.

If you notice the following code snippet in your HTML content:

```html
<div>
  <esi:include src="http://domain.com/index.php/page_cache/block/esi/blocks"/>
</div>
```

It indicates a misconfiguration in your Varnish setup and shows that the ESI html tags are not rendered by varnish.

## Configuring Varnish with ESI Cache

1. Verify Nginx Configuration:
   Ensure that Nginx is correctly configured to work with Varnish.

2. Start Varnish Daemon:
   Start the Varnish daemon with the necessary features enabled. Use the following command:

   ```bash
   -p feature=+esi_ignore_other_elements \
   -p feature=+esi_disable_xml_check \
   -p feature=+esi_ignore_https \
   -p http_resp_hdr_len=16k \
   -p http_resp_size=64k \
   -p workspace_backend=64k \
   ```

   If using systemd, create a custom configuration file at `/etc/systemd/system/varnish.service.d/customexec.conf` with the specified content.
  
```bash
    [Service]
    ExecStart=
    ExecStart=/usr/sbin/varnishd -j unix,user=vcache -F \
    -a :80 \
    -T localhost:6082 \
    -f /etc/varnish/default.vcl \
    -S /etc/varnish/secret \
    -p feature=+esi_ignore_other_elements \
    -p feature=+esi_disable_xml_check \
    -p feature=+esi_ignore_https \
    -p http_resp_hdr_len=16k \
    -p http_resp_size=64k \
    -p workspace_backend=64k \
    -s malloc,256m
```
And reload systemd

```bash
sudo systemctl daemon-reload
```

3. Enable ESI Processing:
   Modify your Varnish default.vcl file (usually located at `/etc/varnish/default.vcl`) to include ESI processing. Add the following line within the `vcl_backend_response` section:

   ```vcl
   sub vcl_backend_response {
   ...
   set beresp.do_esi = true;
   }
   ```

## Restart Varnish

After making these configurations, restart the Varnish service using the following command:

```bash
sudo service varnish restart
```

By following these steps, you can address issues related to Magento ESI Varnish Cache not functioning as expected.