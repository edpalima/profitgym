<?php

namespace Database\Seeders;

use App\Models\WorkoutGuide;
use Illuminate\Database\Seeder;

class WorkoutGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workouts = [
            [
                'title' => 'Full Body Strength Blast',
                'featured_photo' => 'workout-guides/class-1.jpg',
                'description' => "
                    <p><strong>Barbell Squats</strong> – 4 sets of 5 reps</p>
                    <p>The barbell squat is a highly effective compound movement that targets multiple muscle groups, including the quads, glutes, hamstrings, and lower back. Performing squats regularly can help build overall strength, increase lower-body power, and improve functional movement. Make sure to engage your core and maintain proper form to avoid injury and maximize the benefits of this movement.</p>
                    <p><strong>Deadlifts</strong> – 3 sets of 5 reps</p>
                    <p>Deadlifts are one of the most powerful full-body exercises, engaging the legs, back, and core. This movement is essential for building posterior chain strength, which is important for better posture and overall functional strength. Keep your back straight, drive through your heels, and focus on hinging at the hips to execute this lift correctly.</p>
                    <p><strong>Bench Press</strong> – 4 sets of 5 reps</p>
                    <p>The bench press targets the chest, shoulders, and triceps, making it one of the best exercises for upper body pushing strength. Focus on controlled movements, lower the bar to your chest, and avoid bouncing the bar off your chest to prevent injury. You can gradually increase the weight as your strength improves.</p>
                    <p><strong>Pull-Ups</strong> – 3 sets to failure</p>
                    <p>Pull-ups are a fantastic bodyweight exercise that focuses on building upper body strength, particularly in the back and biceps. If you're unable to do pull-ups, start with assisted pull-ups or use a resistance band. Over time, your upper body strength will improve, allowing you to perform unassisted pull-ups.</p>
                    <p><strong>Plank</strong> – 3 sets of 60 seconds</p>
                    <p>The plank is an isometric exercise that strengthens the core, improving stability and endurance. It also engages the shoulders, back, and glutes. Ensure your body forms a straight line from head to heels, and avoid letting your hips sag to prevent unnecessary strain on your lower back. Over time, you can increase the duration as your core strength improves.</p>
                    <p><strong>Additional Notes:</strong> Proper form is key in all exercises. Start with lighter weights to perfect your technique before increasing the load. Stay consistent, and over time, you'll notice significant improvements in strength and muscle definition.</p>
                ",
            ],
            [
                'title' => 'Upper Body Hypertrophy',
                'featured_photo' => 'workout-guides/class-2.jpg',
                'description' => "
                    <p><strong>Incline Dumbbell Press</strong> – 4 sets of 10 reps</p>
                    <p>The incline dumbbell press primarily targets the upper portion of the chest, as well as the shoulders and triceps. This variation of the bench press allows for a greater range of motion and helps build strength in the upper chest. Maintain a controlled movement, and avoid letting your elbows flare out excessively to protect your shoulder joints.</p>
                    <p><strong>Seated Row</strong> – 3 sets of 12 reps</p>
                    <p>The seated row targets the muscles of the upper back, including the lats, traps, and rhomboids. It's a great movement for improving posture and building a strong back. Focus on squeezing your shoulder blades together at the peak of the movement, and ensure you're pulling the weight towards your torso, not your face.</p>
                    <p><strong>Overhead Press</strong> – 4 sets of 8 reps</p>
                    <p>The overhead press is a fundamental shoulder exercise that targets the deltoids, triceps, and upper chest. This lift also engages the core for stability. Keep your body upright, avoid arching your lower back, and press the bar or dumbbells directly overhead in a straight line for maximum efficiency.</p>
                    <p><strong>Bicep Curls</strong> – 3 sets of 15 reps</p>
                    <p>Bicep curls are a classic exercise for isolating the biceps. Use a full range of motion, ensuring that you're curling the weight all the way to the top and controlling the descent. This exercise is excellent for building arm strength and size, and it can also improve your grip strength.</p>
                    <p><strong>Tricep Pushdowns</strong> – 3 sets of 12 reps</p>
                    <p>Tricep pushdowns isolate the triceps and are essential for building arm strength. Focus on keeping your elbows close to your body and fully extending your arms at the bottom of the movement. You can use a rope attachment or a straight bar, depending on your preference.</p>
                    <p><strong>Additional Notes:</strong> For hypertrophy, focus on progressive overload by gradually increasing the weight or reps over time. Also, remember to include a proper warm-up and cool-down routine to prevent injury and improve recovery.</p>
                ",
            ],
            [
                'title' => 'Leg Day Shred',
                'featured_photo' => 'workout-guides/class-3.jpg',
                'description' => "
                    <p><strong>Back Squats</strong> – 5 sets of 5 reps</p>
                    <p>Back squats are a staple lower-body exercise that strengthens the quads, glutes, and hamstrings. They also engage the core and lower back for stability. Make sure to maintain a neutral spine throughout the movement and avoid letting your knees collapse inward.</p>
                    <p><strong>Romanian Deadlifts</strong> – 4 sets of 8 reps</p>
                    <p>Romanian deadlifts focus on the hamstrings, glutes, and lower back. Keep the barbell close to your body as you hinge at the hips, and avoid rounding your back during the movement to ensure proper form and prevent injury.</p>
                    <p><strong>Lunges</strong> – 3 sets of 12 reps per leg</p>
                    <p>Lunges are an excellent unilateral exercise that targets the quads, glutes, and hamstrings. They also improve balance and coordination. Step forward with one leg, lowering your hips until both knees are bent at about 90 degrees.</p>
                    <p><strong>Leg Press</strong> – 4 sets of 10 reps</p>
                    <p>The leg press machine is a great alternative to squats for building leg strength, particularly in the quads. Make sure to adjust the seat so that your knees form a 90-degree angle at the bottom of the movement, and focus on driving the weight through your heels.</p>
                    <p><strong>Calf Raises</strong> – 3 sets of 20 reps</p>
                    <p>Calf raises target the calves, an often-overlooked muscle group. Perform calf raises slowly, pausing at the top for a brief second to maximize muscle activation.</p>
                    <p><strong>Additional Notes:</strong> It's important to focus on muscle mind connection during leg day. Ensure you're engaging the target muscles throughout the movement to get the most benefit from each exercise.</p>
                ",
            ],
            [
                'title' => 'Cardio Burn Circuit',
                'featured_photo' => 'workout-guides/class-4.jpg',
                'description' => "
                    <p><strong>Jump Rope</strong> – 3 minutes</p>
                    <p>Jump rope is an excellent cardiovascular exercise that enhances coordination and improves footwork. It also helps burn calories and increases stamina. Perform the jumps with quick, small movements and try to keep the rope moving consistently throughout the 3-minute duration.</p>
                    <p><strong>Burpees</strong> – 3 sets of 15 reps</p>
                    <p>Burpees are a full-body exercise that can elevate your heart rate quickly. This exercise is great for building endurance, strength, and explosiveness. Make sure to use a wide stance during the squat portion and push through the heels during the jump.</p>
                    <p><strong>Mountain Climbers</strong> – 3 sets of 40 seconds</p>
                    <p>Mountain climbers are a dynamic movement that works the core, shoulders, and legs. Maintain a fast pace, keeping your core tight and your back flat throughout the movement.</p>
                    <p><strong>High Knees</strong> – 3 sets of 30 seconds</p>
                    <p>High knees improve cardiovascular fitness while targeting the hip flexors and lower abs. Keep your posture upright and focus on bringing your knees up to waist height for optimal form.</p>
                    <p><strong>Bicycle Crunches</strong> – 3 sets of 20 reps</p>
                    <p>Bicycle crunches target the obliques and help improve rotational strength. Keep the movement controlled and ensure your elbows stay wide to avoid straining your neck.</p>
                    <p><strong>Additional Notes:</strong> Cardio burn circuits are designed to keep your heart rate elevated while providing a full-body workout. Perform each exercise with maximum intensity for the best fat-burning results.</p>
                ",
            ],
            [
                'title' => 'Core & Mobility Focus',
                'featured_photo' => 'workout-guides/class-5.jpg',
                'description' => "
                    <p><strong>Plank Variations</strong> – 3 sets of 60 seconds</p>
                    <p>Planks are fantastic for strengthening the core, improving stability, and enhancing posture. In addition to standard planks, try side planks and plank leg lifts to target different areas of the core. Keep your body aligned, and avoid letting your hips sag.</p>
                    <p><strong>Russian Twists</strong> – 3 sets of 20 reps</p>
                    <p>Russian twists are great for strengthening the obliques and improving rotational movement. Engage your core, and try to keep your feet off the floor to increase the difficulty.</p>
                    <p><strong>Hip Bridges</strong> – 4 sets of 12 reps</p>
                    <p>Hip bridges target the glutes and lower back, improving hip mobility and strengthening the posterior chain. Squeeze your glutes at the top of the movement and avoid arching your back.</p>
                    <p><strong>Cat-Cow Stretch</strong> – 3 sets of 10 reps</p>
                    <p>The cat-cow stretch is an excellent exercise for improving spinal mobility and flexibility. Move slowly between the two positions, focusing on your breath to maximize the stretch.</p>
                    <p><strong>Additional Notes:</strong> Incorporating mobility exercises into your routine will help improve flexibility, reduce the risk of injury, and enhance overall movement quality.</p>
                ",
            ],

        ];

        foreach ($workouts as $workout) {
            WorkoutGuide::create($workout);
        }
    }
}
