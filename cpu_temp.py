import sensors

sensors.init()
try:
    for chip in sensors.iter_detected_chips():
          for feature in chip:
            print str(feature.get_value())
finally:
    sensors.cleanup()