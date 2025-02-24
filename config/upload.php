<?php

return [
    'validation_rules' => [
        'file' => 'required|file|max:15360000|mimes:iso,img,vhd,vhdx,qcow2,ova,ovf', // Updated to include additional file types
    ],
];