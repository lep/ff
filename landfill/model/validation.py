#!/usr/bin/env python
#-*- coding:utf-8 -*-

import yaml
types = [
    "int",
    "float",
    "string",
    "id",
    "datetime"

]
class Region(object):
    def __init__(self, onleavemethod):
        self.onleave = onleavemethod
        
    def __enter__(self):
        pass
    
    def __exit__(self, type, value, traceback):
        self.onleave()

class YAMLValidator(object):
    def __init__(self):
        self.trace = list()
        
    def enter(self, region):
        self.trace.append(region)
        return Region(self.leave)
        
    def leave(self):
        del self.trace[-1]
    
    def fault(self, error):
        raise Exception (
            "\n".join(self.trace)+
            "\n"+
            error
        )
    
    def assertType(self, value, type):
        if not isinstance(value, type):
            self.fault("Value %s has unexpected type.\n%s was expected" 
                % (value, type))
    
    def validateType(self, typename):
        if typename not in ["string", "int", "float", "id", "bool"]:
            self.fault("Unknown column type %s" % typename)
    
    def validateColumn(self, name, column):
        with self.enter("Validating Column '%s'" % name):
            self.assertType(column, dict)
            for name in column.keys():
                self.assertType(name, basestring)   
                if name not in ("default", "type"):
                    self.fault("Expected 'default' or 'type'")
            if not column.has_key("type"):
                self.fault("Missing type declaration")
            self.assertType(column["type"], basestring)
            self.validateType(column["type"])
            if column.has_key("default"):
                default = column["default"]
                if (not isinstance(default, basestring)) and \
                   (not isinstance(default, float)) and \
                   (not isinstance(default, int)):
                   self.fault("Defaultvalue %s has unexpected type %s" % 
                       (default, type(default)))
            
    
    def validateTable(self, name, table):
        with self.enter("Validating Table '%s'" % name):
            self.assertType(table, dict)
            for name in table.keys():
                self.assertType(name, basestring)
                self.validateColumn(name, table[name])
    
    def validateData(self, data):
        with self.enter("Validating"):
            self.assertType(data, dict)
            for name in data.keys():
                self.assertType(name, basestring)
                self.validateTable(name, data[name])
        

def validate(data):
	y = YAMLValidator();
	y.validateData(data)
	return data
