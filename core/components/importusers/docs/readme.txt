--------------------
Snippets: ImportUsers
--------------------
Author: Michael Graham <michael@collaborativemedia.ca>

This module allows you to import multiple users at once via a CSV file (one
row per user).

The following fields are supported:

    field           notes
    -----           

    username

    password        optional; if absent, a password will be automatically generated        

    active          1=yes, 0=no (default==1)

    groups          comma-delimited list of group memberships
                    each group membership is in the form of
                    name:rank.  For instance:  

                        Members:0,Premium Content:1,Newsletter Editors:2

                    The user group that has a rank of 0 will be set as the
                    user's primary user group.

                    comma-delimited list of group memberships
                    each group membership is in the form of 
                    name:role:rank.  For instance:  

                        Content Editors:Member:0,Premium Content:Member:1,Newsletter Editors:Super User:2
                    
                    The user group that has a rank of 0 will be set as the 
                    user's primary user group.  
                    
                    Role and rank are optional.  
                    Role defaults to "Member" and rank defaults to 0.  
                    
                    Note that rank is not supported on versions less than MODx 2.2.2'
                                                    
    fullname        
                                                    
    email           
    phone           
    mobilephone     
    blocked         1=yes, 0=no      (default==0)          
    blockedafter    date string (e.g. 12/31/1979).  Requires MODx 2.2.2     
    blockeduntil    date string (e.g. 12/31/1979).  Requires MODx 2.2.2     
    dob             date string (e.g. 12/31/1979).  Requires MODx 2.2.2
    gender          M=male, F=female
    address         
    country         
    city            
    state           
    zip             
    fax             
    comment         
    website         
    extended        json string 




