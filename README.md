# Magenerds_SystemDiff

This extension is the successor of [TechDivision_SystemConfigDiff](https://github.com/techdivision/TechDivision_SystemConfigDiff) 
for Magento 2. Data from one Magento instance can be compared with another instance. This is useful if you have a test
and a live system and you have to compare its data, i.e. system configuration. It is designed to be extended via `di.xml` 
in order to integrate more differs and readers.

## Requirements

Magento version >= 2.2
 
## Configuration

The extension must be installed on both the local and remote instance.

In order to connect two systems you need to configure the web service API. 

An integration (```System > Integrations```) must exist on the *remote* system 
with the API resource

```Stores > Settings > Configuration > System Diff Section``` 

The Access Token of this integration must be used on the *local* instance in

```Stores > Configuration > Magenerds > SystemDiff > Connection > Access Token```

You can choose REST or SOAP as API to use in

```Stores > Configuration > Magenerds > SystemDiff > Connection > API Type```

Enter the url of the remote system in

```Stores > Configuration > Magenerds > SystemDiff > Connection > Remote System URL```

The module must be enabled in the system configuration to compare a remote configuration:

```Stores > Configuration > Magenerds > SystemDiff > General > Enabled```

To actually see the field differences between the instances in the system configuration, the display must be enabled:

```Stores > Configuration > Magenerds > SystemDiff > Display > Store configuration diff```


## Backend Usage
In the system configuration of the module 

```Stores > Configuration > Magenerds > SystemDiff > Connection```

is a `Run` button which triggers the sync between local and remote system
and starts the diff.
 
## Command Line Usage
The diff can be initiated via CLI command:

`bin/magento system-diff:execute`

## Cron Job Usage
There is a cron job defined which triggers a diff every hour.

## Integrate your own differs and readers
We implemented differ and reader pools which hold concrete differ and reader implementations configured via `di.xml`.
Of course it is necessary to add a differ and a compatible data reader. The data reader's job is to know how to read the
requested data from the database. The differ's job is to receive the local and remote data in order to diff both data
sets. In order to integrate your own data reader and differ, add the following to your `di.xml`:
 
    <type name="Magenerds\SystemDiff\Differ\DifferPool">
        <arguments>
            <argument name="differs" xsi:type="array">
                <item name="yourDifferKey" xsi:type="string">Namespace\Module\Differ\YourOwnDiffer</item>
            </argument>
        </arguments>
    </type>
    
    <type name="Magenerds\SystemDiff\DataReader\DataReaderPool">
        <arguments>
            <argument name="dataReaders" xsi:type="array">
                <item name="yourDataReaderKey" xsi:type="string">Namespace\Module\DataReader\YourOwnReader</item>
            </argument>
        </arguments>
    </type>