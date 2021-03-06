# This file is part of NfQuery.  NfQuery is free software: you can
# redistribute it and/or modify it under the terms of the GNU General Public
# License as published by the Free Software Foundation, version 3.
#
# This program is distributed in the hope that it will be useful, but WITHOUT
# ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
# FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
# details.
#
# You should have received a copy of the GNU General Public License along with
# this program; if not, write to the Free Software Foundation, Inc., 51
# Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
#
# Copyright NfQuery Team Members

#!/usr/local/bin/python

# Malware Database (AMaDa) :: AMaDa Blocklist Parser

import time
import os
import sys 
import simplejson as json

# importable functions 
__all__ = ['parse_source']

def parse_source_and_create_output(source_name, source_file, output_type, output_file):
    '''
        Honeypot Source Parser
    '''
    update_time = time.strftime('%Y-%m-%d %H:%M')

    try:
        source = open(source_file, "r")
        outputfile = open(output_file, "w")
    except Exception, e:
        print 'Exception'
        print e
        sys.exit(1)

    expr_list = []
    # parse the file line by line
    # for each line we want another query,
    # so create json dump for each ip:port-ip:port couple
    for line in map(str.strip, source):
        if not line.startswith("#") and line != "":
            src_ip = line.split("\n")[0]
            expr_list.append({'src_ip' : src_ip})

    # JSON
    output = [ 
               {
                'source_name' : source_name,
                'date' : update_time,
                'mandatory_keys' : ['src_ip'],
                'expr_list' : expr_list 
               } 
             ]

    #print json_dict
    outputfile.write(json.dumps(output, indent=4))
    outputfile.close()
    source.close()


if __name__ == "__main__":
    print 'calling main'

    # making parameter assignments manually for now.

    source_name = 'Spyeye'
    source_dir  = os.path.dirname(__file__)
    print source_dir
    source_file = source_dir + '/spyeyeSource.txt'
    output_type  = 3
    output_file = source_dir + '/spyeyeOutput.txt'
    
    #fetch_source(source_link, source_file)
    try:
        parse_source_and_create_output(source_name, source_file, output_type, output_file)
    except Exception,e:
        print e


