This module extends the s3fc cores modules in two ways.


1. Adds a new script mnn_s3.js that automatically uploads the file once the user has selected it.

2. Replaces the script from the s3fs cores "s3fs_cors.js" with a custom script "mnn_s3fs_cors.js" one.
This script is a copy of the original with two changes. Both changes start with a comment "// MNN modification" and
end with "// End of MNN modification".
The two changes are:
  A. Automatically submitting the node form as soon as the file finishes uploading.
  B. Change the AJAX call to use "withCredentials: false" instead of "withCredentials: true"
