import cv2
from PIL import Image, ImageDraw, ImageSequence
import numpy as np

# Load the image
image_path = "path_to_your_image.jpg"
image = Image.open(image_path)

# Create a list to store frames
frames = []

# Define the number of frames for the animation
num_frames = 10

# Create frames with a simple blinking effect
for i in range(num_frames):
    frame = image.copy()
    draw = ImageDraw.Draw(frame)
    
    # Create a blinking effect by drawing rectangles over the eyes
    if i % 2 == 0:
        # Draw rectangles over the eyes (coordinates need to be adjusted based on the image)
        draw.rectangle((120, 90, 160, 110), fill=(0, 0, 0))
        draw.rectangle((220, 90, 260, 110), fill=(0, 0, 0))
    
    frames.append(frame)

# Save the frames as a GIF
frames[0].save("animated_image.gif", save_all=True, append_images=frames[1:], duration=100, loop=0)

print("Animation created and saved as animated_image.gif")